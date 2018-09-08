<?php

use Fisharebest\Webtrees\Bootstrap4;
use Fisharebest\Webtrees\Functions\FunctionsEdit;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\View;
use MagicSunday\Webtrees\AncestralFanChartModule;

?>

<div id="page-fan">
    <h2 class="wt-page-title"><?= $title ?></h2>

    <form class="wt-page-options wt-page-options-fan-chart d-print-none">
        <input type="hidden" name="route" value="module">
        <input type="hidden" name="module" value="ancestral-fan-chart">
        <input type="hidden" name="ged" value="<?= e($tree->getName()) ?>">
        <input type="hidden" name="action" value="FanChart">

        <fieldset class="form-group">
            <div class="row">
                <label class="col-sm-3 col-form-label wt-page-options-label" for="xref">
                    <?= I18N::translate('Individual') ?>
                </label>
                <div class="col-sm-9 wt-page-options-value">
                    <?= FunctionsEdit::formControlIndividual($tree, $individual, ['id' => 'xref', 'name' => 'xref']) ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group">
            <div class="row">
                <label class="col-sm-3 col-form-label wt-page-options-label" for="fanDegree">
                    <?= I18N::translate('Layout'); ?>
                </label>
                <div class="col-sm-9 wt-page-options-value">
                    <?=
                        Bootstrap4::select(
                            $fanDegrees,
                            $fanDegree,
                            [
                                'id'   => 'fanDegree',
                                'name' => 'fanDegree',
                            ]
                        );
                    ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group">
            <div class="row">
                <label class="col-sm-3 col-form-label wt-page-options-label" for="generations">
                    <?= I18N::translate('Generations'); ?>
                </label>
                <div class="col-sm-9 wt-page-options-value">
                    <?=
                        Bootstrap4::select(
                            FunctionsEdit::numericOptions(range(AncestralFanChartModule::MIN_GENERATIONS, AncestralFanChartModule::MAX_GENERATIONS)),
                            $generations,
                            [
                                'id'   => 'generations',
                                'name' => 'generations',
                            ]
                        );
                    ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group">
            <div class="row">
                <label class="col-sm-3 col-form-label wt-page-options-label" for="fontScale">
                    <?= I18N::translate('Font size'); ?>
                </label>
                <div class="col-sm-9 wt-page-options-value">
                    <div class="input-group">
                        <input class="form-control" type="text" name="fontScale" id="fontScale" size="3" value="<?= $fontScale; ?>">
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group">
            <div class="row">
                <label class="col-form-label col-sm-3 wt-page-options-label">
                    <?= I18N::translate('Layout'); ?>
                </label>
                <div class="col-sm-9 wt-page-options-value">
                    <?=
                        Bootstrap4::checkbox(
                            I18N::translate('Hide empty segments'),
                            false,
                            [
                                'id'      => 'hideEmptySegments',
                                'name'    => 'hideEmptySegments',
                                'checked' => $hideEmptySegments,
                            ]
                        );
                    ?>
                    <?=
                        Bootstrap4::checkbox(
                            I18N::translate('Show color gradients'),
                            false,
                            [
                                'id'      => 'showColorGradients',
                                'name'    => 'showColorGradients',
                                'checked' => $showColorGradients,
                            ]
                        );
                    ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group">
            <div class="row">
                <div class="col-sm-3 wt-page-options-label"></div>
                <div class="col-sm-9 wt-page-options-value">
                    <input class="btn btn-primary" type="submit" value="<?= I18N::translate('view') ?>">
                    <input class="btn btn-primary" type="reset" value="<?= I18N::translate('reset') ?>" id="resetButton">
                </div>
            </div>
        </fieldset>
    </form>

    <div class="row">
        <div id="fan_chart" class="wt-ajax-load wt-page-content wt-chart wt-fan-chart"></div>
    </div>
</div>

<?php View::push('styles') ?>

<link rel="stylesheet" type="text/css" href="modules_v3/ancestral-fan-chart/css/ancestral-fan-chart.css">

<?php View::endpush(); ?>

<?php View::push('javascript'); ?>

<script type="text/javascript" src="modules_v3/ancestral-fan-chart/js/ancestral-fan-chart.min.js"></script>
<script type="text/javascript">

function AncestralFanChart(data)
{
    rso.options = new rso.Options(
        data.individualUrl,
        data.updateUrl,
        data.labels,
        data.generations,
        data.fanDegree,
        data.defaultColor,
        data.fontScale,
        data.fontColor,
        data.hideEmptySegments,
        data.showColorGradients,
        data.rtl
    );

// console.log(rso.options);

    rso.options = Object.assign({}, rso.options, data);

    rso.initChart();
    rso.initData(rso.options.data);
    rso.createArcElements();
    rso.updateViewBox();
}

new AncestralFanChart(<?= $chartParams ?>);

</script>

<?php View::endpush(); ?>