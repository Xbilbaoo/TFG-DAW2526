export interface User {
  user_id: number;
  email: string;
  password_hash: string;
  role: 'admin' | 'restaurateur';
  avatar_url?: string;
  restaurant_id: number;
}
