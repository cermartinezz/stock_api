<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MakeStockHistoryTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table=$this->table('stock_histories');
        $table
            ->addColumn('user_id', 'integer')
            ->addColumn('date','date')
            ->addColumn('name','string',['limit'=>128])
            ->addColumn('symbol','string',['limit'=>128])
            ->addColumn('open','string',['limit'=>128])
            ->addColumn('high','string',['limit'=>128])
            ->addColumn('low','string',['limit'=>128])
            ->addColumn('close','string',['limit'=>128])
            ->addForeignKey('user_id', 'users', 'id')
            ->addTimestamps()
            ->create();
    }
}
