<?php namespace BizMark\Flexicon\Classes\Api\Get;

use Cache;
use BizMark\Flexicon\Models\BoxName;
use BizMark\Flexicon\Models\PaperName;
use BizMark\Flexicon\Models\PrintType;
use BizMark\Flexicon\Models\Settings;

class Calculator
{
    public function handle()
    {
//        return Cache::remember('payload', 30, function() {
            return $this->getPayload();
//        });
    }

    protected function getPayload()
    {
        $boxNames = BoxName::with('box_types')->get()->toArray();
        $paperNames = PaperName::with('paper_types')->get()->toArray();
        $printType = PrintType::get()->toArray();

        $settings['margin'] = Settings::get('margin');
        $settings['laminar_margin'] = Settings::get('laminar_margin', 0);
        $settings['cost_prepress'] = Settings::get('cost_prepress');
        $settings['cost_fee'] = Settings::get('cost_fee');
        $settings['cost_cutting'] = Settings::get('cost_cutting');
        $settings['cost_other'] = Settings::get('cost_other');
        $settings['cost_pack_10_50'] = Settings::get('cost_pack_10_50');
        $settings['cost_pack_51_100'] = Settings::get('cost_pack_51_100');
        $settings['cost_pack_101_200'] = Settings::get('cost_pack_101_200');
        $settings['cost_pack_201_300'] = Settings::get('cost_pack_201_300');
        $settings['cost_pack_301_500'] = Settings::get('cost_pack_301_500');
        $settings['cost_pack_501_more'] = Settings::get('cost_pack_501_more');

        return [
            'main' => $settings,
            'box_names' => $boxNames,
            'paper_names' => $paperNames,
            'print_types' => $printType,
        ];
    }
}
