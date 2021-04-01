<?php

use Phoenix\Migration\AbstractMigration;

class HayatusSahaba extends AbstractMigration
{
    protected function up(): void
    {
        if (!$this->tableExists('hayatus_sahaba')) {
            $this->table('hayatus_sahaba', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_general_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('book_id', 'integer')
            ->addColumn('chapter_id', 'integer')
            ->addColumn('chapter_name', 'string', ['length' => 200])
            ->addColumn('description', 'text')
            ->addColumn('page_no', 'string', ['null' => true, 'length' => 20])
            ->create();
        }
        if (!$this->tableExists('hayatus_sahaba_chapter_list')) {
            $this->table('hayatus_sahaba_chapter_list', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_general_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('book_id', 'integer')
            ->addColumn('book_name', 'string', ['length' => 200])
            ->addColumn('chapter_id', 'integer')
            ->addColumn('chapter_name', 'string', ['length' => 200])
            ->addColumn('chapter_title', 'string', ['null' => true])
            ->addColumn('page_bn', 'string', ['length' => 50])
            ->addColumn('page_en', 'integer')
            ->addIndex('chapter_id', 'unique', 'btree', 'chapter_id')
            ->create();
        }
    }

    protected function down(): void
    {
        if ($this->tableExists('hayatus_sahaba')) {
             $this->table('hayatus_sahaba')
            ->drop();
        }
        if ($this->tableExists('hayatus_sahaba_chapter_list')) {
           $this->table('hayatus_sahaba_chapter_list')
            ->drop();
        }
    }
}