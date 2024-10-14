<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $bookings = $this->bookingService->getAllBookings($request);
            return response()->json($bookings);
        } catch (Exception $e) {
            return response()->json(['error' => 'Не удалось получить бронь', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(CreateBookingRequest $request): JsonResponse
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated());
            return response()->json($booking, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Не удалось создать бронь', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $booking = $this->bookingService->getBookingById($id);
            return response()->json($booking);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Бронь не найдена', 'message' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Не удалось получить бронь', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateBookingRequest $request, $id): JsonResponse
    {
        try {
            $booking = $this->bookingService->updateBooking($id, $request->validated());
            return response()->json($booking);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Бронь не найдена', 'message' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Не удалось обновить бронь', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->bookingService->deleteBooking($id);
            return response()->json(['message' => 'Бронь успешно удалена'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Бронь не найдена', 'message' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Не удалось удалить бронь', 'message' => $e->getMessage()], 500);
        }
    }

    public function userBookings($userId, Request $request): JsonResponse
    {
        try {
            $bookings = $this->bookingService->getUserBookings($userId, $request);
            return response()->json($bookings);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Пользователь не найден', 'message' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Не удалось получить брони пользователя', 'message' => $e->getMessage()], 500);
        }
    }
}
