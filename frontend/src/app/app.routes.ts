import { Routes } from '@angular/router';
import { Home } from './pages/home/home';
import { Menu } from './pages/menu/menu';
import { Admin } from './pages/admin/admin';
import { Shifts } from './pages/shifts/shifts';
import { Login } from './pages/login/login';
import { Booking } from './pages/booking/booking';
import { Dashboard } from './pages/dashboard/dashboard';

export const routes: Routes = [
  { path: '', component: Home },
  { path: 'menu', component: Menu },
  { path: 'admin', component: Admin },
  { path: 'reservas', component: Booking },
  { path: 'turnos', component: Shifts },
  { path: 'login', component: Login },
  { path: 'dashboard', component: Dashboard },
  { path: '**', redirectTo: '' }
];
