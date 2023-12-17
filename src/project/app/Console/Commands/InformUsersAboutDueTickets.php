<?php

namespace App\Console\Commands;

use App\Mail\PassedDueTicketNotification;
use App\Models\JobLog;
use App\Services\LoanPenaltyService;
use App\Services\Tickets\TicketingService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class InformUsersAboutDueTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:notify_passed_due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will notify users about passed due tickets (tasks)';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private readonly TicketingService $ticketingService)
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        $startTime = Carbon::now();

        $this->info('Running check users having passed due tickets');

        $usersWithPassedDueTickets = $this->ticketingService->getPassedDueTickets();

        if ($usersWithPassedDueTickets->isEmpty())
        {
            $this->info('No Past due tickets ...good job :) !');
        }
        else
        {
            //WE push here to a new mail template including the ticket details ..and notifying the user about passed due ..

            //TODO this should be pushed to a queue ( redis or RabbitMQ or ..) and job should be handled to process those emails ..for performace ..
            foreach ($usersWithPassedDueTickets as $userTicket){
                $recipient = $userTicket->user->email;
                Mail::to($recipient)->send(new PassedDueTicketNotification($userTicket));
            }

        }


        $this->info('Done!');
    }
}
