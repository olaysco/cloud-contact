<?php

namespace Expose\Export;

class Arrays extends \Expose\Export
{
    public function render()
    {
        $lines = array();
        $data = $this->getData();
        $outArray = array();

        foreach ($data as $report) {
            $var[] = ['variable'=> $report->getVarName(),
                       'value' => $report->getVarValue(),
                       'path'  => json_encode($report->getVarPath())
                    ];

            // $line = '';
            // $line .= 'Variable: '.$report->getVarName();
            // $line .= ' | Value: '.$report->getVarValue();
            // $line .= ' | Path: '.json_encode($report->getVarPath());
            // $line .= "\n########################\n";
            $filters[] = array();
            foreach ($report->getFilterMatch() as $filter) {
                $filters[] = ['Description'=>$filter->getDescription(),
                             'id'=>$filter->getId(),
                             'impact'=>$filter->getImpact(),
                              'tags'=>implode(', ', $filter->getTags())
                            ];
                // $line .= "Description: (".$filter->getId().") ".$filter->getDescription()."\n";
                // $line .= "Impact: ".$filter->getImpact();
                // $line .= " | Tags: ".implode(', ', $filter->getTags());
                // $line .= "\n";
            }
            // $lines[] = $line;
            $outArray[] = ['var'=>$var, 'filter'=>$filters];
        }

        // return implode("\n", $lines);
        return $outArray;
    }
}
