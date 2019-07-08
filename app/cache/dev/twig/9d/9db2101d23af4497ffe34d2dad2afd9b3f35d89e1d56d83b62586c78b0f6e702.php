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

/* NBMainBundle:Seatseller:account.html.twig */
class __TwigTemplate_a29b2083cf5ab0b1dec3649a1657f1a5a3da5a900c672e2bf900e5bdcbee80f5 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'pagestyle' => [$this, 'block_pagestyle'],
            'contentheader' => [$this, 'block_contentheader'],
            'content' => [$this, 'block_content'],
            'pagescript' => [$this, 'block_pagescript'],
            'script' => [$this, 'block_script'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "NBMainBundle:Seatseller:account.html.twig"));

        $this->parent = $this->loadTemplate("::base.html.twig", "NBMainBundle:Seatseller:account.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo " Seatseller  ";
        $this->displayParentBlock("title", $context, $blocks);
        echo " ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 4
    public function block_pagestyle($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pagestyle"));

        // line 5
        echo "     <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\HttpFoundationExtension']->generateAbsoluteUrl($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/plugins/datatables/dataTables.bootstrap.css")), "html", null, true);
        echo "\">
 ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 8
    public function block_contentheader($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "contentheader"));

        // line 9
        echo "    <h1>
        Seatseller
        <small>Solde du compte</small>
    </h1>
    <ol class=\"breadcrumb\">
        <li><a href=\"";
        // line 14
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("nb_main_homepage");
        echo "\"><i class=\"fa fa-dashboard\"></i> Accueil</a></li>
        <li class=\"active\">Seatsellers</li>
    </ol>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 19
    public function block_content($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content"));

        // line 20
        echo "    <div class=\"row\">
        <div class=\"col-md-6\">
            <!-- general form elements -->
            <div class=\"box box-primary\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">Recharge du compte de ";
        // line 25
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["seatseller"]) || array_key_exists("seatseller", $context) ? $context["seatseller"] : (function () { throw new RuntimeError('Variable "seatseller" does not exist.', 25, $this->source); })()), "nomAgence", []), "html", null, true);
        echo "</h3>
                </div>
                <form method=\"post\">
                <div class=\"box-body\">
                    <div class=\"form-group\">
                        <label>Montant</label>
                        <input name=\"montant\" class=\"form-control\" type=\"text\" />
                    </div>

                </div>
                <!-- /.box-body -->

                <div class=\"box-footer\">
                    <button type=\"submit\" class=\"btn btn-primary\">Enregistrer</button>
                </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <div class=\"col-md-6\">
            <!-- general form elements -->
            <div class=\"box box-primary\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">Solde </h3>
                </div>
                    <div class=\"box-body\">
                        <h3>Le solde de votre compte est : </h3>
                        <h2 class=\"page-header text-center\">";
        // line 52
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["solde"]) || array_key_exists("solde", $context) ? $context["solde"] : (function () { throw new RuntimeError('Variable "solde" does not exist.', 52, $this->source); })()), 2, ".", " "), "html", null, true);
        echo " FCFA</h2>

                    </div>
                </div>
            </div>
    </div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 60
    public function block_pagescript($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pagescript"));

        // line 61
        echo "    <!-- iCheck 1.0.1 -->
    <script src=\"";
        // line 62
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\HttpFoundationExtension']->generateAbsoluteUrl($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/plugins/iCheck/icheck.min.js")), "html", null, true);
        echo "\"></script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 66
    public function block_script($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "script"));

        // line 67
        echo "    <!-- page script -->
    <script>
        \$(function () {

        });
    </script>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "NBMainBundle:Seatseller:account.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  190 => 67,  184 => 66,  175 => 62,  172 => 61,  166 => 60,  152 => 52,  122 => 25,  115 => 20,  109 => 19,  98 => 14,  91 => 9,  85 => 8,  75 => 5,  69 => 4,  55 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends '::base.html.twig' %}

{% block title %} Seatseller  {{ parent() }} {% endblock %}
 {% block pagestyle %}
     <link rel=\"stylesheet\" href=\"{{ absolute_url(asset('assets/plugins/datatables/dataTables.bootstrap.css')) }}\">
 {% endblock %}

{% block contentheader %}
    <h1>
        Seatseller
        <small>Solde du compte</small>
    </h1>
    <ol class=\"breadcrumb\">
        <li><a href=\"{{ path('nb_main_homepage') }}\"><i class=\"fa fa-dashboard\"></i> Accueil</a></li>
        <li class=\"active\">Seatsellers</li>
    </ol>
{% endblock %}

{% block content %}
    <div class=\"row\">
        <div class=\"col-md-6\">
            <!-- general form elements -->
            <div class=\"box box-primary\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">Recharge du compte de {{ seatseller.nomAgence }}</h3>
                </div>
                <form method=\"post\">
                <div class=\"box-body\">
                    <div class=\"form-group\">
                        <label>Montant</label>
                        <input name=\"montant\" class=\"form-control\" type=\"text\" />
                    </div>

                </div>
                <!-- /.box-body -->

                <div class=\"box-footer\">
                    <button type=\"submit\" class=\"btn btn-primary\">Enregistrer</button>
                </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <div class=\"col-md-6\">
            <!-- general form elements -->
            <div class=\"box box-primary\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">Solde </h3>
                </div>
                    <div class=\"box-body\">
                        <h3>Le solde de votre compte est : </h3>
                        <h2 class=\"page-header text-center\">{{ solde |number_format(2, '.', ' ' ) }} FCFA</h2>

                    </div>
                </div>
            </div>
    </div>
{% endblock %}

{% block pagescript %}
    <!-- iCheck 1.0.1 -->
    <script src=\"{{ absolute_url(asset('assets/plugins/iCheck/icheck.min.js')) }}\"></script>
{% endblock %}


{% block script %}
    <!-- page script -->
    <script>
        \$(function () {

        });
    </script>

{% endblock %}", "NBMainBundle:Seatseller:account.html.twig", "/Applications/MAMP/htdocs/administration/src/NB/MainBundle/Resources/views/Seatseller/account.html.twig");
    }
}
