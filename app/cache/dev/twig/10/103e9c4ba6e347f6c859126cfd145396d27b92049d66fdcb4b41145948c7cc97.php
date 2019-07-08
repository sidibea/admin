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

/* NBMainBundle:Seatseller:list.html.twig */
class __TwigTemplate_49ff8bd3ce2366f64f341510ef108643826c36c6dbbe12f91076a54020e0510b extends \Twig\Template
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "NBMainBundle:Seatseller:list.html.twig"));

        $this->parent = $this->loadTemplate("::base.html.twig", "NBMainBundle:Seatseller:list.html.twig", 1);
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
        Axes
        <small>Liste des Seatsellers</small>
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
        echo "<div class=\"row\">
    <div class=\"col-md-12\">
        <div class=\"box\">
            <div class=\"box-header\">
                <h3 class=\"box-title\">Seatseller (";
        // line 24
        echo twig_escape_filter($this->env, twig_length_filter($this->env, (isset($context["list"]) || array_key_exists("list", $context) ? $context["list"] : (function () { throw new RuntimeError('Variable "list" does not exist.', 24, $this->source); })())), "html", null, true);
        echo ")</h3>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">

                <table id=\"company\" class=\"table table-bordered table-striped\">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Imm.</th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Quartier</th>
                        <th>Email</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["list"]) || array_key_exists("list", $context) ? $context["list"] : (function () { throw new RuntimeError('Variable "list" does not exist.', 42, $this->source); })()));
        foreach ($context['_seq'] as $context["key"] => $context["val"]) {
            // line 43
            echo "                        <tr>
                            <td width=\"10\">";
            // line 44
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["val"], "id", []), "html", null, true);
            echo "</td>
                            <td><b>";
            // line 45
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["val"], "numeroNina", []), "html", null, true);
            echo "</b></td>
                            <td>";
            // line 46
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["val"], "nom", []), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["val"], "prenom", []), "html", null, true);
            echo "</td>
                            <td>";
            // line 47
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["val"], "ville", []), "html", null, true);
            echo "</td>
                            <td>";
            // line 48
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["val"], "quartier", []), "nom", []), "html", null, true);
            echo "</td>
                            <td>";
            // line 49
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["val"], "email", []), "html", null, true);
            echo "</td>

                            <td>
                                <div class=\"text-center\">
                                    <a href=\"";
            // line 53
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("nb_main_modifier_seatseller", ["id" => twig_get_attribute($this->env, $this->source, $context["val"], "id", [])]), "html", null, true);
            echo "\" class=\"btn btn-social-icon btn-bitbucket\"><i class=\"fa fa-edit\"></i></a>
                                    <a href=\"";
            // line 54
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("nb_main_seatseller_solde_compte", ["seatseller_id" => twig_get_attribute($this->env, $this->source, $context["val"], "id", [])]), "html", null, true);
            echo "\" class=\"btn btn-social-icon btn-flickr\"><i class=\"fa fa-money\"></i></a>
                                    <a href=\"\"  onclick=\" return confirm('Voulez vous vraiment cette ligne ?')\" class=\"btn btn-social-icon btn-google\"><i class=\"fa fa-times\"></i></a>
                                </div>
                            </td>
                        </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 60
        echo "                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Imm.</th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Quartier</th>
                        <th>Email</th>
                        <th>Options</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 80
    public function block_pagescript($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pagescript"));

        // line 81
        echo "        <!-- DataTables -->
        <script src=\"";
        // line 82
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\HttpFoundationExtension']->generateAbsoluteUrl($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/plugins/datatables/jquery.dataTables.min.js")), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 83
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\HttpFoundationExtension']->generateAbsoluteUrl($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/plugins/datatables/dataTables.bootstrap.min.js")), "html", null, true);
        echo "\"></script>
    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 87
    public function block_script($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "script"));

        // line 88
        echo "    <!-- page script -->
    <script>
        \$(function () {
            \$(\"#example1\").DataTable();
            \$('#company').DataTable({
                \"paging\": true,
                \"lengthChange\": false,
                \"searching\": true,
                \"ordering\": true,
                \"info\": true,
                \"autoWidth\": false
            });
        });
    </script>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "NBMainBundle:Seatseller:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  247 => 88,  241 => 87,  232 => 83,  228 => 82,  225 => 81,  219 => 80,  194 => 60,  182 => 54,  178 => 53,  171 => 49,  167 => 48,  163 => 47,  157 => 46,  153 => 45,  149 => 44,  146 => 43,  142 => 42,  121 => 24,  115 => 20,  109 => 19,  98 => 14,  91 => 9,  85 => 8,  75 => 5,  69 => 4,  55 => 3,  39 => 1,);
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
        Axes
        <small>Liste des Seatsellers</small>
    </h1>
    <ol class=\"breadcrumb\">
        <li><a href=\"{{ path('nb_main_homepage') }}\"><i class=\"fa fa-dashboard\"></i> Accueil</a></li>
        <li class=\"active\">Seatsellers</li>
    </ol>
{% endblock %}

{% block content %}
<div class=\"row\">
    <div class=\"col-md-12\">
        <div class=\"box\">
            <div class=\"box-header\">
                <h3 class=\"box-title\">Seatseller ({{ list|length }})</h3>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">

                <table id=\"company\" class=\"table table-bordered table-striped\">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Imm.</th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Quartier</th>
                        <th>Email</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for key, val in list %}
                        <tr>
                            <td width=\"10\">{{ val.id }}</td>
                            <td><b>{{ val.numeroNina }}</b></td>
                            <td>{{ val.nom }} {{ val.prenom }}</td>
                            <td>{{ val.ville }}</td>
                            <td>{{  val.quartier.nom }}</td>
                            <td>{{ val.email }}</td>

                            <td>
                                <div class=\"text-center\">
                                    <a href=\"{{ path('nb_main_modifier_seatseller', {'id': val.id}) }}\" class=\"btn btn-social-icon btn-bitbucket\"><i class=\"fa fa-edit\"></i></a>
                                    <a href=\"{{ path('nb_main_seatseller_solde_compte', {'seatseller_id': val.id}) }}\" class=\"btn btn-social-icon btn-flickr\"><i class=\"fa fa-money\"></i></a>
                                    <a href=\"\"  onclick=\" return confirm('Voulez vous vraiment cette ligne ?')\" class=\"btn btn-social-icon btn-google\"><i class=\"fa fa-times\"></i></a>
                                </div>
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Imm.</th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Quartier</th>
                        <th>Email</th>
                        <th>Options</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    {% endblock %}

    {% block pagescript %}
        <!-- DataTables -->
        <script src=\"{{ absolute_url(asset('assets/plugins/datatables/jquery.dataTables.min.js')) }}\"></script>
        <script src=\"{{ absolute_url(asset('assets/plugins/datatables/dataTables.bootstrap.min.js')) }}\"></script>
    {% endblock %}


    {% block script %}
    <!-- page script -->
    <script>
        \$(function () {
            \$(\"#example1\").DataTable();
            \$('#company').DataTable({
                \"paging\": true,
                \"lengthChange\": false,
                \"searching\": true,
                \"ordering\": true,
                \"info\": true,
                \"autoWidth\": false
            });
        });
    </script>

{% endblock %}", "NBMainBundle:Seatseller:list.html.twig", "/Applications/MAMP/htdocs/administration/src/NB/MainBundle/Resources/views/Seatseller/list.html.twig");
    }
}
