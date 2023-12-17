<?php

namespace App\Services\Tickets;


use App\Core\BaseModel;
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskCategory;
use App\Models\Users\UserTicket;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;


class TicketingService
{
    public function __construct()
    {

    }


    public function getUserTickets(int $userId): Collection
    {
        $userTickets = UserTicket::query()
                                 ->forUser($userId)
                                 ->with('categories')
                                 ->get();


        return $userTickets;
    }


    public function assignTicketToUser(array $payload): UserTicket
    {

        $ticketUser = new UserTicket();
        $ticketUser->fill($payload);
        $ticketUser->saveOrFail();

        return UserTicket::query()
                         ->with(['task', 'user'])
                         ->findOrFail($ticketUser->user_ticket_id);

    }


    public function getPassedDueTickets(): Collection
    {
        return UserTicket::query()
                         ->StillActive()
                         ->passedDue()
                         ->get();
    }

}
