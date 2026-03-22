export interface Booking{
  booking_id: number;
  restaurant_id: number;
  shift_id: number;
  booking_date: string;
  booking_time: string;
  adult_guests: number;
  child_guests: number;
  customer_name: string;
  contact_info: string;
  notes?: string; 
}