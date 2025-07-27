<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:categories {file=categories.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import categories from an Excel file and save them into the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the file path
        $file = $this->argument('file');

        // If the file is in storage/app, prefix it with storage_path
        if (!file_exists($file)) {
            $storagePathFile = storage_path('app/' . $file);
            if (file_exists($storagePathFile)) {
                $file = $storagePathFile;
            } else {
                $this->error("File {$file} not found!");
                return 1;
            }
        }

        // Load Excel data
        $data = Excel::toArray([], $file)[0]; // Get first sheet
        $headers = array_shift($data);        // Remove header row

        if (empty($data)) {
            $this->warn("No rows found in the Excel file.");
            return 0;
        }

        $this->info("Importing categories...");
        $bar = $this->output->createProgressBar(count($data));
        $bar->start();

        $inserted = 0;
        $skipped = 0;

        foreach ($data as $row) {
            $bar->advance();

            // Ensure we have at least 4 columns in each row
            if (count($row) < 4 || empty($row[0])) {
                $skipped++;
                continue;
            }

            $category_name = trim($row[0]);
            $sub_category  = trim($row[1] ?? '');
            $service       = trim($row[2] ?? '');
            $keywords      = trim($row[3] ?? '');

            try {
                    Category::create([
                        'category'     => $category_name,
                        'sub_category' => $sub_category,
                        'service'      => $service,
                        'keywords'     => $keywords
                    ]);
            } catch (\Exception $e) {
                $this->error("Error inserting '{$category_name}': " . $e->getMessage());
                $skipped++;
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully imported {$inserted} categories. Skipped {$skipped} rows.");

        return 0;
    }
}
