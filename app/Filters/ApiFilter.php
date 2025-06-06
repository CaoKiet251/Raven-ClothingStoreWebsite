<?php

namespace App\Filters;

use Illuminate\Http\Request;

use function Laravel\Prompts\form;

class ApiFilter{
    // field can filter on
    protected $safeParms = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators)
        {
            $query = $request->query($parm);

            if(!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach($operators as $operator){
                if (isset($query[$operator]))
                {
                    $eloQuery[] = [$column, $this->operatorMap[$operator],$query[$operator]];
                }
            }
        } 
        return $eloQuery;
    }
}