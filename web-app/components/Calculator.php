<?php

namespace WebApp\components;

use Yii;

class Calculator
{

    function filterData($data, $type, $category)
    {
        $data = PaintType::$data;
        $filteredData = [];
        foreach ($data as $row) {
            if ($row['type'] == $type && $row['category'] == $category) {
                $filteredData[] = $row;
            }
        }
        return $filteredData;
    }

    function calculatePackages($area, $rate, $package)
    {
        $result = [];
        $remainingArea = $area;
        $data = PaintType::$data;
        $lastIndex = count($package) - 1;
        foreach (array_reverse($package) as $index => $pkg) {
            if ($remainingArea == 0) {
                continue;
            }
            
            $literCount = $remainingArea / $rate;
            $modulo = $remainingArea % $rate;
            if ($literCount < $pkg && $modulo != 0) {
                if (($index === $lastIndex)) {
                    $result[] = [1, $pkg];
                }
                continue;
            }

            $pkgCount = floor($literCount / $pkg);
            if ($pkgCount == 0) {
                $result[] = [1, $pkg];
                // $remainingArea -= ($pkgCount * $rate);
            }
            if ($pkgCount > 0) {
                $result[] = [$pkgCount, $pkg];
                $remainingArea -= ($literCount * $rate);
            }
        }
        return $result;
    }

    function calc($type, $category, $area)
    {
        $data = PaintType::$data;
        $filteredData = $this->filterData($data, $type, $category);
        $recommendation = [];
        foreach ($filteredData as $row) {
            $primer = $row['primer'];
            $rate = $row['rate'];

            $topcoat_rate = $row['topcoat_rate'];
            $topcoat = $row['topcoat'];

            $primerPackages = $this->calculatePackages($area, $rate, $row['package']);

            $topcoatPackages = $this->calculatePackages($area, $topcoat_rate, $row['topcoat_package']);
            $text = [];
            foreach ($primerPackages as $pkg) {
                $text[] = $pkg[0] . " x " . $primer . " " . $pkg[1] . "Ltr";
            }
            $coatText = [];
            foreach ($topcoatPackages as $pkg) {
                $coatText[] = $pkg[0] . " x " . $topcoat . " "  . $pkg[1] . "Ltr";
            }

            $recommendation[] = [
                "primer" => $primer,
                "package_primer" => $text,
                "top_coat" => $topcoat,
                "packaget_top_coat" => $coatText,
                "image_primer" => Yii::$app->params['host'] . "/product/" . $primer . ".png",
                "image_coat" => Yii::$app->params['host'] . "/product/" . $topcoat . ".png"
            ];
            // echo "Type: " . $type . "\n";
            // echo "Category: " . $category . "\n";
            // echo "Primer: " . $primer . "\n";
            // echo "Rate: " . $rate . "\n";
            // echo "Area: " . $area . "\n";
            // echo "Primer Packages: \n";


            // echo "Topcoat: " . $topcoat . "\n";
            // echo "Topcoat Rate: " . $topcoat_rate . "\n";
            // echo "Topcoat Packages: \n";


            // echo "----------------\n";
        }

        return $recommendation;
    }
}
