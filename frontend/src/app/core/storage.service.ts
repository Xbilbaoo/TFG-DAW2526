//Sirve para almacenar el token de un usuario, este servicio habla con el navegador
// para recoger datos y ponerlos en el localStorage

import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class StorageService {

  private TOKEN_KEY = 'auth_token';
  //GETS THE TOKEN FROM THE USER
  getToken(): string | null {
    return localStorage.getItem(this.TOKEN_KEY);
  }
  //SET THE TOKEN FROM THE API, LOGIN
  setToken(token: string): void {
    localStorage.setItem(this.TOKEN_KEY, token);
  }
  //REMOVES THE TOKEN, LOG OUT
  clear(): void {
    localStorage.removeItem(this.TOKEN_KEY);
  }
  //VERIFIES IF USER IS LOGGED IN
  isLoggedIn(): boolean {
    return this.getToken() !== null;
  }
}
