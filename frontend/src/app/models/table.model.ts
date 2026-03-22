export interface Table {
  table_id: number;
  restaurant_id: number;
  number: number;
  seats: number;
  status: 'available' | 'occupied' | 'reserved';
  position_x: number;
  position_y: number;
}
