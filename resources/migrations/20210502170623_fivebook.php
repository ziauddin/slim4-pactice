<?php

use Phoenix\Migration\AbstractMigration;

class Fivebook extends AbstractMigration
{
    protected function up(): void
    {
        if (!$this->tableExists('book_content')) {
        $this->table('book_content', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_general_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('volume_id', 'integer')
            ->addColumn('chapter_id', 'integer')
            ->addColumn('chapter_name', 'string')
            ->addColumn('description', 'text')
            ->addColumn('page_no', 'string', ['null' => true, 'length' => 20])
            ->addColumn('data_type', 'integer', ['null' => true, 'default' => 1])
            ->addColumn('book_id', 'integer', ['null' => true, 'default' => 1])
            ->create();
        }
        if (!$this->tableExists('book_list')) {
        $this->table('book_list', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_general_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('book_name', 'string', ['length' => 150])
            ->addColumn('author_name', 'string', ['null' => true, 'length' => 200])
            ->addColumn('has_volume', 'integer', ['null' => true])
            ->addColumn('rank_no', 'integer', ['null' => true])
            ->addColumn('active', 'integer', ['null' => true])
            ->create();
        }
        if (!$this->tableExists('chapter_list')) {
            $this->table('chapter_list', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_general_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('volume_id', 'integer')
            ->addColumn('book_name', 'string', ['length' => 150])
            ->addColumn('chapter_id', 'integer')
            ->addColumn('chapter_name', 'string', ['length' => 200])
            ->addColumn('chapter_title', 'string', ['null' => true, 'length' => 200])
            ->addColumn('page_bn', 'string', ['null' => true, 'length' => 5])
            ->addColumn('page_en', 'integer', ['null' => true])
            ->addColumn('book_id', 'integer', ['null' => true])
            ->addColumn('active', 'integer', ['null' => true])
            ->create();
        }
        if (!$this->tableExists('volume_list')) {
        $this->table('volume_list', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_general_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('book_id', 'integer', ['null' => true])
            ->addColumn('volume_id', 'integer', ['null' => true])
            ->addColumn('name', 'string', ['null' => true, 'length' => 150])
            ->addColumn('title', 'string', ['null' => true])
            ->addColumn('has_child', 'integer', ['null' => true])
            ->addColumn('chapter_id', 'integer', ['null' => true])
            ->addColumn('active', 'integer', ['null' => true, 'default' => 1])
            ->create();
        }
    }

    protected function down(): void
    {
        if ($this->tableExists('book_content')) {
        $this->table('book_content')
            ->drop();
        }
        if ($this->tableExists('book_list')) {
        $this->table('book_list')
            ->drop();
        }
        if ($this->tableExists('chapter_list')) {
        $this->table('chapter_list')
            ->drop();
        }
        if ($this->tableExists('volume_list')) {
            $this->table('volume_list')
                ->drop();
        }
    }
}
