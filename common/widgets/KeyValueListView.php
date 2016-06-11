<?php

namespace app\common\widgets;

use Yii;
use yii\base\Arrayable;
use yii\i18n\Formatter;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

/**
 * Widget for display list of links to related models
 */
class KeyValueListView extends Widget
{
    /**
     * @var \yii\data\DataProviderInterface the data provider for the view. This property is required.
     */
    public $dataProvider;
    
    /**
     * @var string|callable the template used to render a single model. If a string, the token `{label}`
     * and `{value}` will be replaced with the label and the value of the corresponding model.
     * If a callback (e.g. an anonymous function), the signature must be as follows:
     *
     * ```php
     * function ($model, $index, $widget)
     * ```
     *
     * where `$model` refer to the specification of the model being rendered, `$index` is the zero-based
     * index of the model in the [[models]] array, and `$widget` refers to this widget instance.
     */
    public $template = '<tr><th>{label}</th><td>{value}</td></tr>';
    /**
     * @var array the HTML attributes for the container tag of this widget. The "tag" option specifies
     * what container tag should be used. It defaults to "table" if not set.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'table table-striped table-bordered detail-view'];
    /**
     * @var array|Formatter the formatter used to format model attribute values into displayable texts.
     * This can be either an instance of [[Formatter]] or an configuration array for creating the [[Formatter]]
     * instance. If this property is not set, the "formatter" application component will be used.
     */
    public $formatter;
    /**
     * @var string Property that stands for the label
     */
    public $label;

    /**
     * @var string Property that stands for the value
     */
    public $value;
    
    /**
     * @var string Property that stands for the format
     */
    public $format;
    
    /**
     * @var string Property that stands for the text to be displayed when dataProvider return no results
     */
    public $emptyText;

    /**
     * Initializes the detail view.
     * This method will initialize required property values.
     */
    public function init()
    {
        if ($this->dataProvider === null) {
            throw new InvalidConfigException('Please specify the "dataProvider" property.');
        }
        if ($this->label === null) {
            throw new InvalidConfigException('Please specify the "label" property.');
        }
        if ($this->value === null) {
            throw new InvalidConfigException('Please specify the "value" property.');
        }
        if ($this->format === null) {
        	$this->format = 'text';
        }
        if ($this->formatter === null) {
            $this->formatter = Yii::$app->getFormatter();
        } elseif (is_array($this->formatter)) {
            $this->formatter = Yii::createObject($this->formatter);
        }
        if (!$this->formatter instanceof Formatter) {
            throw new InvalidConfigException('The "formatter" property must be either a Format object or a configuration array.');
        }
    }

    /**
     * Renders the detail view.
     * This is the main entry of the whole detail view rendering.
     */
    public function run()
    {
        $rows = [];
        $i = 0;

        foreach ($this->dataProvider->getModels() as $model) {
            $rows[] = $this->renderModel($model, $i++);
        }
        $options = $this->options;
        
        $tag = ArrayHelper::remove($options, 'tag', 'table');
        
        
        if (empty($rows)){
        	$content = "<tbody><tr><td class=\"text-center\" colspan=\"2\">" . $this->emptyText. "</td></tr>\n</tbody>";
        	echo Html::tag($tag, $content, $options);
        }
        else{
        	echo Html::tag($tag, implode("\n", $rows), $options);
        }
        
        
    }
    
    /**
     * Renders a single model.
     * @param array $model the specification of the model to be rendered.
     * @param integer $index the zero-based index of the attribute in the [[models]] array
     * @return string the rendering result
     */
    protected function renderModel($model, $index)
    {

        if (is_string($this->template)) {
            return strtr($this->template, [
                '{label}' =>  ArrayHelper::getValue($model,$this->label),
                '{value}' => $this->formatter->format(ArrayHelper::getValue($model ,$this->value), $this->format),
            ]);
        } else {
            return call_user_func($this->template, $model, $index, $this);
        }
    }
}