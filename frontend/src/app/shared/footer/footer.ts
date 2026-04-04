import { Component } from '@angular/core';

@Component({
  selector: 'app-footer',
  template: `
    <footer class="footer">
      <div class="footer-main">
        <div class="footer-container">
          <!-- Logo y contacto -->
          <div class="footer-section">
            <div class="footer-logo">
              <span class="logo-icon">🍴</span>
              <span class="logo-text">La Trattoria</span>
            </div>
            <div class="contact-info">
              <div class="contact-item">
                <i class="icon-map"></i>
                <span>Calle Mayor 45, Palermo, Sicilia</span>
              </div>
              <div class="contact-item">
                <i class="icon-phone"></i>
                <span>+39 091 123 4567</span>
              </div>
              <div class="contact-item">
                <i class="icon-clock"></i>
                <span>Lun-Dom 12:00 - 23:00</span>
              </div>
            </div>
          </div>
          
          <!-- Enlaces rápidos -->
          <div class="footer-section">
            <h4>Explora</h4>
            <ul class="footer-links">
              <li><a routerLink="/menu">Carta Completa</a></li>
              <li><a routerLink="/reservas">Reservas Online</a></li>
              <li><a routerLink="/turnos">Horarios</a></li>
              <li><a href="#">Menú Degustación</a></li>
            </ul>
          </div>
          
          <!-- Servicios -->
          <div class="footer-section">
            <h4>Servicios</h4>
            <ul class="footer-links">
              <li><a href="#">Eventos Privados</a></li>
              <li><a href="#">Catering</a></li>
              <li><a href="#">Terraza</a></li>
              <li><a href="#">Take Away</a></li>
            </ul>
          </div>
          
          <!-- Gestión -->
          <div class="footer-section">
            <h4>Gestión</h4>
            <ul class="footer-links">
              <li><a routerLink="/admin">Panel Admin</a></li>
              <li><a routerLink="/login">Acceso Restaurador</a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="footer-bottom">
        <div class="footer-container">
          <div class="legal">
            <p>&copy; 2026 La Trattoria. Todos los derechos reservados.</p>
            <p>TFG Ander Muñoz && Xabier Bilbao  - Desarrollo Full Stack (Angular + Laravel)</p>
          </div>
          <div class="social-links">
            <a href="#" class="social-link">Instagram</a>
            <a href="#" class="social-link">Facebook</a>
            <a href="#" class="social-link">TripAdvisor</a>
          </div>
        </div>
      </div>
    </footer>
  `,
  styles: [`
    :host { display: block; }
    
    .footer {
      background: linear-gradient(180deg, #1a1a1a 0%, #0d0d0d 100%);
      color: #e0e0e0;
      margin-top: auto;
    }
    
    .footer-main {
      border-bottom: 1px solid #333;
    }
    
    .footer-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 4rem 2rem 2rem;
    }
    
    .footer-section {
      flex: 1;
      min-width: 200px;
      margin-right: 3rem;
    }
    
    .footer-section:last-child {
      margin-right: 0;
    }
    
    .footer-logo {
      display: flex;
      align-items: center;
      margin-bottom: 1.5rem;
      gap: 0.75rem;
    }
    
    .logo-icon {
      font-size: 2rem;
      color: #f8e8a6;
    }
    
    .logo-text {
      font-size: 1.5rem;
      font-weight: 700;
      color: white;
    }
    
    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .contact-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 0.95rem;
    }
    
    .icon-map, .icon-phone, .icon-clock {
      width: 20px;
      height: 20px;
      color: #f8e8a6;
      flex-shrink: 0;
    }
    
    .footer-section h4 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      color: white;
    }
    
    .footer-links {
      list-style: none;
      padding: 0;
    }
    
    .footer-links li {
      margin-bottom: 0.75rem;
    }
    
    .footer-links a {
      color: #b0b0b0;
      text-decoration: none;
      font-size: 0.95rem;
      transition: color 0.3s ease;
    }
    
    .footer-links a:hover {
      color: #f8e8a6;
    }
    
    .footer-bottom {
      padding: 2rem;
      background: #111;
      border-top: 1px solid #222;
    }
    
    .footer-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 2rem;
    }
    
    .legal p {
      margin: 0 0 0.5rem 0;
      font-size: 0.9rem;
      opacity: 0.8;
    }
    
    .social-links {
      display: flex;
      gap: 1.5rem;
    }
    
    .social-link {
      color: #b0b0b0;
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      transition: color 0.3s ease;
    }
    
    .social-link:hover {
      color: #f8e8a6;
    }
    
    @media (max-width: 768px) {
      .footer-container {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
      }
      
      .footer-section {
        margin-right: 0;
        text-align: center;
      }
      
      .social-links {
        order: -1;
      }
    }
  `]
})
export class FooterComponent { }
