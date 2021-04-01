<?php

use Phoenix\Migration\AbstractMigration;

class Content extends AbstractMigration
{
    protected function up(): void
    {
        if (!$this->tableExists('db_content')) {
            $this->table('db_content', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('content', 'text')
            ->addColumn('page_no', 'string', ['length' => 100])
            ->addColumn('kitab_name', 'string', ['length' => 150])
            ->addColumn('chapter_name', 'string')
            ->create();
        }


    }

    protected function down(): void
    {
        $this->table('db_content')
            ->drop();
    }
}