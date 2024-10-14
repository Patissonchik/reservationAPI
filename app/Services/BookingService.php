<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BookingService
{
    public function getAllBookings($request)
    {
        try {
            $query = Booking::query();

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            return $query->paginate($request->get('limit', 10), ['*'], 'page', $request->get('offset', 1));
        } catch (Exception $e) {
            throw new Exception('Ошибка при получении бронирований: ' . $e->getMessage());
        }
    }

    public function getBookingById($id)
    {
        try {
            return Booking::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Бронирование не найдено: ' . $e->getMessage());
        }
    }

    public function createBooking(array $data)
    {
        try {
            return Booking::create($data);
        } catch (Exception $e) {
            throw new Exception('Ошибка при создании бронирования: ' . $e->getMessage());
        }
    }

    public function updateBooking($id, array $data)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update($data);

            return $booking;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Бронирование не найдено: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Ошибка при обновлении бронирования: ' . $e->getMessage());
        }
    }

    public function deleteBooking($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Бронирование не найдено: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Ошибка при удалении бронирования: ' . $e->getMessage());
        }
    }

    public function getUserBookings($userId, $request)
    {
        try {
            return Booking::where('user_id', $userId)
                          ->paginate($request->get('limit', 10), ['*'], 'page', $request->get('offset', 1));
        } catch (Exception $e) {
            throw new Exception('Ошибка при получении бронирований пользователя: ' . $e->getMessage());
        }
    }
}
