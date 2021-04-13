<?php

use Phoenix\Migration\AbstractMigration;

class Jiboni extends AbstractMigration
{
    protected function up(): void
    {
        if (!$this->tableExists('jiboni')) {
            $this->table('jiboni', 'id')
                ->setCharset('utf8mb4')
                ->setCollation('utf8mb4_0900_ai_ci')
                ->addColumn('id', 'integer', ['autoincrement' => true])
                ->addColumn('title', 'string')
                ->addColumn('desc', 'text')
                ->create();
        }
    }

    protected function down(): void
    {
        if ($this->tableExists('jiboni')) {
            $this->table('jiboni')
                ->drop();
        }
    }
}