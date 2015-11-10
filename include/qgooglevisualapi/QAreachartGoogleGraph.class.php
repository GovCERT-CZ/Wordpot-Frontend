<?php

/**
 * Wrapper for Google Visualisation API
 * Visualisation type: area chart
 * @author Thomas Sch�fer
 * @since 2008-06-29
 *
 */
class QAreachartGoogleGraph extends QVizualisationGoogleGraph
{

    /**
     * visualisation type holder
     *
     * @var string
     */
    protected $vizualisationType = "AreaChart";

    /**
     * default property holder
     *
     * @var array
     */
    protected $drawProperties = array("width" => 400, "height" => 240, "legend" => "bottom");

    /**
     * holder for google api package name
     *
     * @var string
     */
    protected $package = "";

    /**
     * holder for default properties
     *
     * @var array
     */
    protected $configuration = array(
        "axisColor" => array("datatype" => "string,object"),
        "axisBackgroundColor" => array("datatype" => "string,object"),
        "backgroundColor" => array("datatype" => "string,object"),
        "borderColor" => array("datatype" => "string,object"),
        "colors" => array("datatype" => "array"),
        "focusBorderColor" => array("datatype" => "string,object"),
        "height" => array("datatype" => "integer"),
        "isStacked" => array("datatype" => "bool"),
        "legend" => array(
            "values" => array("right", "left", "top", "bottom", "none"),
            "datatype" => "string"
        ),
        "legendBackgroundColor" => array("datatype" => "string,object"),
        "legendTextColor" => array("datatype" => "string,object"),
        "lineSize" => array("datatype" => "integer"),
        "pointSize" => array("datatype" => "integer"),
        "reverseAxis" => array("datatype" => "bool"),
        "title" => array("datatype" => "string"),
        "titleX" => array("datatype" => "string"),
        "titleY" => array("datatype" => "string"),
        "titleColor" => array("datatype" => "string,object"),
        "width" => array("datatype" => "integer"),
    );

}
