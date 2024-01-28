<?php

namespace App\Services;

use App\Enums\CurrencyType;
use Socket;
use Carbon\Carbon;
use App\Models\User;
use Error;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class RconService
{
    /**
     * Socket creation
     *
     * @var Socket resource
     */
    protected Socket $socket;

    /**
     * Socket connected
     *
     * @var boolean resource
     */
    protected $connected;

    /**
     * Initialise socket connection
     *
     * @return void
     */
    protected function connect(): void
    {
        if (!config('hotel.rcon.enabled')) return;

        if (!function_exists('socket_create')) {
            abort(500, sprintf("socket_create function doesn't exist. PHP Error: [%s]", socket_strerror(socket_last_error())));
        }

        try {
            $this->socket = socket_create(config('hotel.rcon.domain'), config('hotel.rcon.type'), config('hotel.rcon.protocol'));
        } catch (\Throwable) {
            throw new Error(sprintf('socket_create failed. PHP Error: [%s]', socket_strerror(socket_last_error())));
        }

        try {
            $this->connected = socket_connect($this->socket, config('hotel.rcon.host'), config('hotel.rcon.port'));
        } catch (\Throwable) {
            throw new Error(sprintf('socket_create failed. PHP Error: [%s]', socket_strerror(socket_last_error())));
        }
    }

    /**
     * Send a packet to the tcp server.
     */
    public function sendPacket(string $key, $data = null)
    {
        $this->connect();

        $data = json_encode([
            'key' => $key,
            'data' => $data
        ]);

        $request = socket_write($this->socket, $data, strlen($data));

        if ($request === false) {
            abort(500, sprintf('socket_write failed. PHP Error: [%s]', socket_strerror(socket_last_error())));
        }

        $response = socket_read($this->socket, 2048);
        return json_decode($response);
    }

    /**
     * Send gift to a user.
     */
    public function sendGift(User $user, int $item_id, string $message = 'Here is a gift.')
    {
        return $this->sendPacket('sendgift', [
            'user_id' => $user->id,
            'itemid' => $item_id,
            'message' => $message,
        ]);
    }

    /**
     * Give credits to user.
     */
    public function giveCurrency(User $user, string $currency, int $amount)
    {
        if (! in_array($currency, array_merge(CurrencyType::values(), ['credits']))) return;

        $data = [
            'user_id' => $user->id
        ];

        if ($currency == 'credits') {
            $data[$currency] = $amount;

            return $this->sendPacket('givecredits', $data);
        }

        $data['type'] = (int) $currency;
        $data['points'] = $amount;

        return $this->sendPacket('givepoints', $data);
    }

    /**
     * Disconnect the user.
     *
     * @param user $user
     * @return mixed
     */
    public function disconnectUser(User $user)
    {
        return $this->sendPacket('disconnect', [
            'user_id' => $user->id,
            'username' => $user->username,
        ]);
    }

    /**
     * Mute the user.
     */
    public function muteUser(User $user, Carbon $duration)
    {
        return $this->sendPacket('muteuser', [
            'user_id' => $user->id,
            'duration' => $duration->timestamp
        ]);
    }

    /**
     * Reload user credits.
     */
    public function reloadCredits($user)
    {
        return $this->sendPacket('reloadcredits', [
            'user_id' => $user->id
        ]);
    }

    /**
     * Send badge to a user.
     */
    public function sendBadge(User $user, string $badge)
    {
        return $this->sendPacket('givebadge', [
            'user_id' => $user->id,
            'badge' => $badge,
        ]);
    }

    /**
     * Send badge to a user.
     */
    public function removeBadge(User $user, string $badge)
    {
        return $this->sendPacket('removebadge', [
            'user_id' => $user->id,
            'badge' => $badge,
        ]);
    }

    /**
     * Update users motto.
     */
    public function setMotto(User $user, string $motto)
    {
        return $this->sendPacket('setmotto', [
            'user_id' => $user->id,
            'motto' => $motto,
        ]);
    }

    /**
     * Update the word filter.
     */
    public function updateWordFilter()
    {
        return $this->sendPacket('updatewordfilter');
    }

    /**
     * Update user data.
     */
    public function updateUser(User $user, array $data)
    {
        return $this->sendPacket('updateuser', [
            'user_id' => $user->id,
            ...$data
        ]);
    }

    /**
     * Update users username.
     */
    public function changeUsername(User $user, bool $canChange = false)
    {
        return $this->sendPacket('changeusername', [
            'user_id' => $user->id,
            'canChange' => $canChange,
        ]);
    }

    /**
     * Set users rank.
     */
    public function setRank(User $user, int $rank)
    {
        return $this->sendPacket('setrank', [
            'user_id' => $user->id,
            'rank' => $rank,
        ]);
    }

    /**
     * Update the catalog.
     */
    public function updateCatalog()
    {
        return $this->sendPacket('updatecatalog');
    }

    /**
     * Send user an alert.
     */
    public function alertUser(User $user, string $message)
    {
        return $this->sendPacket('alertuser', [
            'user_id' => $user->id,
            'message' => $message,
        ]);
    }

    /**
     * Send user to a room.
     */
    public function forwardUser(User $user, int $roomId)
    {
        return $this->sendPacket('forwarduser', [
            'user_id' => $user->id,
            'room_id' => $roomId,
        ]);
    }

    /**
     * Send hotel alert.
     */
    public function hotelAlert(string $message, ?string $url)
    {
        return $this->sendPacket('hotelalert', [
            'message' => $message,
            'url' => $url,
        ]);
    }

    /**
     * Send staff alert.
     */
    public function staffAlert(string $message)
    {
        return $this->sendPacket('staffalert', [
            'message' => $message
        ]);
    }

    /**
     * Follow to a user.
     */
    public function followUser(int|User $currentUser, int|User $user)
    {
        return $this->sendPacket('stalkuser', [
            'user_id' => $currentUser instanceof User ? $currentUser->id : $currentUser,
            'follow_id' => $user instanceof User ? $user->id : $user,
        ]);
    }

    public function sendSafely($method, array $args, $fallback = null)
    {
        try {
            $this->{$method}(...$args);
        } catch (\Throwable $e) {
            if ($fallback) $fallback($e);
        }
    }

    public function sendSafelyFromDashboard($method, array $args, $notificationTitle)
    {
        $this->sendSafely(
            $method,
            $args,
            fn () => Notification::make()
                ->danger()
                ->persistent()
                ->title($notificationTitle)
                ->body(__('Please check your RCON connection and try again.'))
                ->send()
        );
    }

    public function sendSafelyFromShop($method, array $args, $notificationTitle)
    {
        $this->sendSafely(
            $method,
            $args,
            fn () => Log::error($notificationTitle)
        );
    }
}
