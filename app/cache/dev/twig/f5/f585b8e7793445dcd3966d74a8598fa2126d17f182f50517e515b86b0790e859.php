<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* NBMainBundle:includes:recap.html.twig */
class __TwigTemplate_67d5eeff393205170a6027fa3171de1a4e6b7e97aa5f9a6992fb507d25b3cd1c extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "NBMainBundle:includes:recap.html.twig"));

        // line 1
        echo "<div class=\"row\">
    <div class=\"col-md-12\">
        <div class=\"box\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Recap Mensuelle</h3>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <p class=\"text-center\">
                            <strong>Ventes : 1 Jan, 2017 - 30 Jul, 2017</strong>
                        </p>

                        <div class=\"chart\">
                            <!-- Sales Chart Canvas -->
                            <canvas id=\"salesChart\" style=\"height: 280px;\"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class=\"box-footer\">
                <div class=\"row\">
                    <div class=\"col-sm-3 col-xs-6\">
                        <div class=\"description-block border-right\">
                            <span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> 17%</span>
                            <h5 class=\"description-header\">\$35,210.43</h5>
                            <span class=\"description-text\">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-sm-3 col-xs-6\">
                        <div class=\"description-block border-right\">
                            <span class=\"description-percentage text-yellow\"><i class=\"fa fa-caret-left\"></i> 0%</span>
                            <h5 class=\"description-header\">\$10,390.90</h5>
                            <span class=\"description-text\">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-sm-3 col-xs-6\">
                        <div class=\"description-block border-right\">
                            <span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> 20%</span>
                            <h5 class=\"description-header\">\$24,813.53</h5>
                            <span class=\"description-text\">TOTAL PROFIT</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-sm-3 col-xs-6\">
                        <div class=\"description-block\">
                            <span class=\"description-percentage text-red\"><i class=\"fa fa-caret-down\"></i> 18%</span>
                            <h5 class=\"description-header\">1200</h5>
                            <span class=\"description-text\">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "NBMainBundle:includes:recap.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"row\">
    <div class=\"col-md-12\">
        <div class=\"box\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Recap Mensuelle</h3>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <p class=\"text-center\">
                            <strong>Ventes : 1 Jan, 2017 - 30 Jul, 2017</strong>
                        </p>

                        <div class=\"chart\">
                            <!-- Sales Chart Canvas -->
                            <canvas id=\"salesChart\" style=\"height: 280px;\"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class=\"box-footer\">
                <div class=\"row\">
                    <div class=\"col-sm-3 col-xs-6\">
                        <div class=\"description-block border-right\">
                            <span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> 17%</span>
                            <h5 class=\"description-header\">\$35,210.43</h5>
                            <span class=\"description-text\">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-sm-3 col-xs-6\">
                        <div class=\"description-block border-right\">
                            <span class=\"description-percentage text-yellow\"><i class=\"fa fa-caret-left\"></i> 0%</span>
                            <h5 class=\"description-header\">\$10,390.90</h5>
                            <span class=\"description-text\">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-sm-3 col-xs-6\">
                        <div class=\"description-block border-right\">
                            <span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> 20%</span>
                            <h5 class=\"description-header\">\$24,813.53</h5>
                            <span class=\"description-text\">TOTAL PROFIT</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-sm-3 col-xs-6\">
                        <div class=\"description-block\">
                            <span class=\"description-percentage text-red\"><i class=\"fa fa-caret-down\"></i> 18%</span>
                            <h5 class=\"description-header\">1200</h5>
                            <span class=\"description-text\">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

", "NBMainBundle:includes:recap.html.twig", "/Applications/MAMP/htdocs/administration/src/NB/MainBundle/Resources/views/includes/recap.html.twig");
    }
}
