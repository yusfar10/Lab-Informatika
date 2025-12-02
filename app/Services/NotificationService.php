<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Bookings;

class NotificationService
{
    /**
     * Create a generic notification
     *
     * @param int $userId
     * @param string $message
     * @param string $type
     * @param int|null $relatedId
     * @param string|null $category
     * @return Notification
     */
    public function createNotification($userId, $message, $type, $relatedId = null, $category = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'message' => $message,
            'type' => $type,
            'related_id' => $relatedId,
            'category' => $category,
            'is_read' => false,
        ]);
    }

    /**
     * Create notification for booking created
     *
     * @param Bookings $booking
     * @return Notification
     */
    public function notifyBookingCreated(Bookings $booking)
    {
        // Load relationships
        $booking->load(['jadwalKelas.laboratorium']);

        $labName = $booking->jadwalKelas->laboratorium->room_name ?? 'Lab';
        $time = $booking->jadwalKelas->start_time->format('H:i');

        $message = "Booking {$labName} {$time} berhasil dibuat!";

        return $this->createNotification(
            $booking->user_id,
            $message,
            'booking_created',
            $booking->booking_id,
            'booking'
        );
    }

    /**
     * Create notification for booking approved
     *
     * @param Bookings $booking
     * @return Notification
     */
    public function notifyBookingApproved(Bookings $booking)
    {
        // Load relationships
        $booking->load(['jadwalKelas.laboratorium']);

        $labName = $booking->jadwalKelas->laboratorium->room_name ?? 'Lab';
        $time = $booking->jadwalKelas->start_time->format('H:i');

        $message = "Booking {$labName} {$time} disetujui!";

        return $this->createNotification(
            $booking->user_id,
            $message,
            'booking_approved',
            $booking->booking_id,
            'booking'
        );
    }

    /**
     * Create notification for booking rejected
     *
     * @param Bookings $booking
     * @param string $reason
     * @return Notification
     */
    public function notifyBookingRejected(Bookings $booking, $reason)
    {
        // Load relationships
        $booking->load(['jadwalKelas.laboratorium']);

        $labName = $booking->jadwalKelas->laboratorium->room_name ?? 'Lab';
        $time = $booking->jadwalKelas->start_time->format('H:i');

        $message = "Booking {$labName} {$time} dibatalkan oleh admin - Alasan: {$reason}";

        return $this->createNotification(
            $booking->user_id,
            $message,
            'booking_rejected',
            $booking->booking_id,
            'booking'
        );
    }
}
