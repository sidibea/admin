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

/* include/header.html.twig */
class __TwigTemplate_d6439ff2e7c13fa0e2eabd02cbdd7d44790e92ea456ecc6564151c1a412931e4 extends \Twig\Template
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "include/header.html.twig"));

        // line 1
        echo "<!-- Logo -->
<a href=\"";
        // line 2
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("nb_main_homepage");
        echo "\" class=\"logo\">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class=\"logo-mini\"><b>next</b>Bus</span>
    <!-- logo for regular state and mobile devices -->
    <span class=\"logo-lg\"><img src=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\HttpFoundationExtension']->generateAbsoluteUrl($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/images/logo.png")), "html", null, true);
        echo "\" alt=\"Logo nextBus\" title=\"Logo nextBus\" /></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class=\"navbar navbar-static-top\">
    <!-- Sidebar toggle button-->
    <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">
        <span class=\"sr-only\">Toggle navigation</span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
    </a>

    <div class=\"navbar-custom-menu\">
        <ul class=\"nav navbar-nav\">

            <!-- Notifications: style can be found in dropdown.less -->
            <li class=\"dropdown notifications-menu\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                    <i class=\"fa fa-bell-o\"></i>
                    <span class=\"label label-warning\">10</span>
                </a>
                <ul class=\"dropdown-menu\">
                    <li class=\"header\">You have 10 notifications</li>
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class=\"menu\">
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-users text-aqua\"></i> 5 new members joined today
                                </a>
                            </li>
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-warning text-yellow\"></i> Very long description here that may not fit into the
                                    page and may cause design problems
                                </a>
                            </li>
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-users text-red\"></i> 5 new members joined
                                </a>
                            </li>
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-shopping-cart text-green\"></i> 25 sales made
                                </a>
                            </li>
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-user text-red\"></i> You changed your username
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"footer\"><a href=\"#\">View all</a></li>
                </ul>
            </li>

            <!-- User Account: style can be found in dropdown.less -->
            <li class=\"dropdown user user-menu\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                    <img src=\"";
        // line 67
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\HttpFoundationExtension']->generateAbsoluteUrl($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/images/logo.png")), "html", null, true);
        echo "\" class=\"user-image\" alt=\"Logo\">
                    <span class=\"hidden-xs\">";
        // line 68
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 68, $this->source); })()), "user", []), "nom", []), "html", null, true);
        echo "</span>
                </a>
                <ul class=\"dropdown-menu\">
                    <!-- User image -->
                    <li class=\"user-header\">
                        <img src=\"";
        // line 73
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\HttpFoundationExtension']->generateAbsoluteUrl($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/images/logo.png")), "html", null, true);
        echo "\" class=\"img-circle\" alt=\"User Image\">

                        <p>
                            ";
        // line 76
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 76, $this->source); })()), "user", []), "nom", []), "html", null, true);
        echo "
                            <small>Dernière connexion le ";
        // line 77
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 77, $this->source); })()), "user", []), "lastLogin", []), "d M Y"), "html", null, true);
        echo "</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class=\"user-footer\">
                        <div class=\"pull-left\">
                            <a href=\"#\" class=\"btn btn-default btn-flat\">Profile</a>
                        </div>
                        <div class=\"pull-right\">
                            <a href=\"";
        // line 86
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("logout");
        echo "\" class=\"btn btn-default btn-flat\">Se deconnecter</a>
                        </div>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "include/header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  146 => 86,  134 => 77,  130 => 76,  124 => 73,  116 => 68,  112 => 67,  48 => 6,  41 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!-- Logo -->
<a href=\"{{ path('nb_main_homepage') }}\" class=\"logo\">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class=\"logo-mini\"><b>next</b>Bus</span>
    <!-- logo for regular state and mobile devices -->
    <span class=\"logo-lg\"><img src=\"{{ absolute_url(asset('assets/images/logo.png')) }}\" alt=\"Logo nextBus\" title=\"Logo nextBus\" /></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class=\"navbar navbar-static-top\">
    <!-- Sidebar toggle button-->
    <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">
        <span class=\"sr-only\">Toggle navigation</span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
    </a>

    <div class=\"navbar-custom-menu\">
        <ul class=\"nav navbar-nav\">

            <!-- Notifications: style can be found in dropdown.less -->
            <li class=\"dropdown notifications-menu\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                    <i class=\"fa fa-bell-o\"></i>
                    <span class=\"label label-warning\">10</span>
                </a>
                <ul class=\"dropdown-menu\">
                    <li class=\"header\">You have 10 notifications</li>
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class=\"menu\">
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-users text-aqua\"></i> 5 new members joined today
                                </a>
                            </li>
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-warning text-yellow\"></i> Very long description here that may not fit into the
                                    page and may cause design problems
                                </a>
                            </li>
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-users text-red\"></i> 5 new members joined
                                </a>
                            </li>
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-shopping-cart text-green\"></i> 25 sales made
                                </a>
                            </li>
                            <li>
                                <a href=\"#\">
                                    <i class=\"fa fa-user text-red\"></i> You changed your username
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"footer\"><a href=\"#\">View all</a></li>
                </ul>
            </li>

            <!-- User Account: style can be found in dropdown.less -->
            <li class=\"dropdown user user-menu\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                    <img src=\"{{ absolute_url(asset('assets/images/logo.png')) }}\" class=\"user-image\" alt=\"Logo\">
                    <span class=\"hidden-xs\">{{ app.user.nom }}</span>
                </a>
                <ul class=\"dropdown-menu\">
                    <!-- User image -->
                    <li class=\"user-header\">
                        <img src=\"{{ absolute_url(asset('assets/images/logo.png')) }}\" class=\"img-circle\" alt=\"User Image\">

                        <p>
                            {{ app.user.nom }}
                            <small>Dernière connexion le {{ app.user.lastLogin |date('d M Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class=\"user-footer\">
                        <div class=\"pull-left\">
                            <a href=\"#\" class=\"btn btn-default btn-flat\">Profile</a>
                        </div>
                        <div class=\"pull-right\">
                            <a href=\"{{ path('logout') }}\" class=\"btn btn-default btn-flat\">Se deconnecter</a>
                        </div>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>", "include/header.html.twig", "/Applications/MAMP/htdocs/administration/app/Resources/views/include/header.html.twig");
    }
}
