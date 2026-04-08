<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use Illuminate\Support\Facades\Log;

class ShowLastJournal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-last-journal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var JournalEntry $entry */
        $entry = JournalEntry::orderBy('id', 'desc')->first();
        if (!$entry) {
            $this->info('No journal entries found.');
            return 0;
        }
        $this->info('Latest Journal Entry:');
        $this->line(json_encode($entry->toArray(), JSON_PRETTY_PRINT));
        $items = JournalItem::where('journal_entry_id', $entry->id)->get();
        $this->info('Related Journal Items:');
        foreach ($items as $item) {
            $this->line(json_encode($item->toArray(), JSON_PRETTY_PRINT));
        }
        return 0;
    }
}
