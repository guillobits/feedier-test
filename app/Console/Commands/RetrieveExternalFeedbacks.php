<?php

namespace App\Console\Commands;

use App\Enum\FeedbackSourceEnum;
use App\Models\Feedback;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class RetrieveExternalFeedbacks extends Command
{
    const EXTERNAL_IMPORT_URL = 'https://feedier-production.s3.eu-west-1.amazonaws.com/special/Reviews+Import.csv';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retrieve-external-feedbacks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve the feedbacks from external source';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get(self::EXTERNAL_IMPORT_URL);
        $csvData = $response->body();

        $reader = Reader::createFromString($csvData);
        $reader->setHeaderOffset(0);

        $importedCount = 0;
        foreach ($reader as $row) {
            Feedback::create([
                'content' => $row['Reviews Content'],
                'source' => FeedbackSourceEnum::EXTERNAL,
            ]);
            $importedCount++;
        }
        $this->line("$importedCount imported feedbacks");
    }
}
