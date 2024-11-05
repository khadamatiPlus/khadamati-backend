<?php

namespace Database\Seeders\EmailEngine;

use App\Domains\EmailEngine\MailableTemplates\SampleTemplate;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Spatie\MailTemplates\Models\MailTemplate;

/**
 * Class EmailTemplateSeeder.
 */
class EmailTemplateSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->truncate('mail_templates');

        /*Sample Template*/
        MailTemplate::create([
            'mailable' => SampleTemplate::class,
            'subject' => 'New {{ $prop1 }} received - ({{ $prop2 }})',
            'html_template' => '<p>Dear Admin,</p><p>Kindly note that a new <strong>{{ $prop1 }}</strong> has been received to <strong>{{ $prop2 }}</strong> under <strong>({{ $prop3 }})</strong></p><p>Thank you.</p>',
        ]);
        $this->enableForeignKeys();
    }
}
