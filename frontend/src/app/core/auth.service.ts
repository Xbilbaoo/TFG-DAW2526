//Aqui se hace la autenticacion, gestionando login,logout y informacion de usuarios loggeados
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap } from 'rxjs';
import { StorageService } from './storage.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiUrl = 'http://localhost/gozkoetxe-api/auth';

  constructor(
    private http: HttpClient,
    private storage: StorageService
  ) {}

  //Peticion Post al backend para hacer el login con gmail y password
  login(email: string, password: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/login`, { email, password }).pipe(
      tap((res: any) => {
        this.storage.setToken(res.token);
      })
    );
  }

  //Llama al servicio de storage para quitar el token y cerrar sesion
  logout(): void {
    this.storage.clear();
  }
  //Llama al servicio de storage para verificar si esta loggado
  isLoggedIn(): boolean {
    return this.storage.isLoggedIn();
  }

  //Metodo utilizado para determinar el rol de un usuario,
  getRole(): string | null {
    const token = this.storage.getToken();
    if (!token) return null;
    const payload = JSON.parse(atob(token.split('.')[1]));
    return payload.role ?? null;
  }
}
