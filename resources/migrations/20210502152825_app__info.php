<?php

use Phoenix\Migration\AbstractMigration;

class App_info extends AbstractMigration
{
    protected function up(): void
    {
        if (!$this->tableExists('app_info')) {
            $this->table('app_info', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_general_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('package', 'string', ['length' => 255])
            ->addColumn('app_name', 'string', ['length' => 100])
            ->addColumn('app_id', 'string', ['length' => 255])
            ->addColumn('app_url', 'string', ['length' => 255, 'null' => true])
            ->addColumn('app_image', 'string', ['null' => true, 'length' => 150])
            ->addColumn('rank', 'integer', ['default' => 0])
            ->addColumn('version', 'integer', ['default' => 0])
            ->addColumn('update', 'integer', ['default' => 0])
            ->create();
        }
    }

    protected function down(): void
    {
        if ($this->tableExists('app_info')) {
            $this->table('app_info')
           ->drop();
       }
    }
}
