import { Component } from '@angular/core';
import { Router, NavigationEnd } from '@angular/router';
import { filter } from 'rxjs/operators';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterModule, CommonModule],
  template: `
    <nav class="navbar">
      <div class="navbar-container">
        <div class="navbar-brand">
          <a routerLink="/" class="brand-logo">
            <span class="logo-icon">🍴</span>
            <span class="brand-name">La Trattoria</span>
          </a>
        </div>
        
        <div class="navbar-menu" [class.mobile-open]="isMobileMenuOpen">
          <ul class="nav-list">
            <li class="nav-item">
              <a routerLink="/" 
                 routerLinkActive="active" 
                 [routerLinkActiveOptions]="{exact: true}"
                 (click)="closeMobileMenu()">
                Inicio
              </a>
            </li>
            <li class="nav-item">
              <a routerLink="/menu" 
                 routerLinkActive="active"
                 (click)="closeMobileMenu()">
                Carta
              </a>
            </li>
            <li class="nav-item">
              <a routerLink="/turnos" 
                 routerLinkActive="active"
                 (click)="closeMobileMenu()">
                Horarios
              </a>
            </li>
            <li class="nav-item">
              <a routerLink="/reservas" 
                 routerLinkActive="active"
                 (click)="closeMobileMenu()">
                Reservas
              </a>
            </li>
            <li class="nav-item dropdown">
              <a routerLink="/admin" 
                 routerLinkActive="active"
                 (click)="closeMobileMenu()">
                Gestión
              </a>
            </li>
            <li class="nav-item">
              <a routerLink="/login" 
                 routerLinkActive="active"
                 (click)="closeMobileMenu()">
                Acceso
              </a>
            </li>
          </ul>
        </div>
        
        <button class="mobile-toggle" (click)="toggleMobileMenu()">
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
        </button>
      </div>
    </nav>
  `,
  styles: [`
    :host { display: block; }
    
    .navbar {
      background: rgba(44, 85, 48, 0.95);
      backdrop-filter: blur(10px);
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }
    
    .navbar-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 70px;
    }
    
    .brand-logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: white;
      font-weight: 700;
      font-size: 1.4rem;
      gap: 0.5rem;
    }
    
    .logo-icon {
      font-size: 1.8rem;
    }
    
    .nav-list {
      display: flex;
      list-style: none;
      gap: 2.5rem;
      margin: 0;
      align-items: center;
    }
    
    .nav-item a {
      color: rgba(255,255,255,0.9);
      text-decoration: none;
      font-weight: 500;
      padding: 0.5rem 0;
      transition: all 0.3s ease;
      position: relative;
    }
    
    .nav-item a:hover,
    .nav-item a.active {
      color: #f8e8a6;
    }
    
    .nav-item a.active::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: #f8e8a6;
    }
    
    .mobile-toggle {
      display: none;
      flex-direction: column;
      background: none;
      border: none;
      padding: 0.5rem;
      cursor: pointer;
    }
    
    .hamburger-line {
      width: 25px;
      height: 3px;
      background: white;
      margin: 3px 0;
      transition: 0.3s;
    }
    
    @media (max-width: 1024px) {
      .navbar-menu {
        display: none;
      }
      .mobile-toggle {
        display: flex;
      }
      .navbar-menu.mobile-open {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        background: rgba(44, 85, 48, 0.98);
        flex-direction: column;
        padding: 2rem;
        animation: slideDown 0.3s ease;
      }
      .nav-list {
        flex-direction: column;
        gap: 1.5rem;
      }
    }
    
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  `]
})
export class NavbarComponent {
  isMobileMenuOpen = false;

  constructor(private router: Router) {
    this.router.events.pipe(
      filter(event => event instanceof NavigationEnd)
    ).subscribe(() => this.closeMobileMenu());
  }

  toggleMobileMenu() {
    this.isMobileMenuOpen = !this.isMobileMenuOpen;
  }

  closeMobileMenu() {
    this.isMobileMenuOpen = false;
  }
}