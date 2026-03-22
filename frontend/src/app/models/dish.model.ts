export interface Dish {
  dish_id: number;
  category_id: number;
  name: string;
  description?: string;
  dish_photo_url?: string;
  price: number;
  is_available: boolean;
  allergens?: string;
  tags?: string;
}
