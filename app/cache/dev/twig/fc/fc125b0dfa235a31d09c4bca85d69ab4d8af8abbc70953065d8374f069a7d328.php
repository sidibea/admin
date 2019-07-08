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

/* @WebProfiler/Profiler/toolbar.html.twig */
class __TwigTemplate_a177da8c759d92890f713b4b7e7fd5061f746a06de9e31a77228e7e641e2458e extends \Twig\Template
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Profiler/toolbar.html.twig"));

        // line 1
        echo "<!-- START of Symfony Web Debug Toolbar -->
<div id=\"sfMiniToolbar-";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 2, $this->source); })()), "html", null, true);
        echo "\" class=\"sf-minitoolbar\" data-no-turbolink>
    <a href=\"javascript:void(0);\" title=\"Show Symfony toolbar\" tabindex=\"-1\" accesskey=\"D\" onclick=\"
        var elem = this.parentNode;
        if (elem.style.display == 'none') {
            document.getElementById('sfToolbarMainContent-";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 6, $this->source); })()), "html", null, true);
        echo "').style.display = 'none';
            document.getElementById('sfToolbarClearer-";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 7, $this->source); })()), "html", null, true);
        echo "').style.display = 'none';
            elem.style.display = 'block';
        } else {
            document.getElementById('sfToolbarMainContent-";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 10, $this->source); })()), "html", null, true);
        echo "').style.display = 'block';
            document.getElementById('sfToolbarClearer-";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 11, $this->source); })()), "html", null, true);
        echo "').style.display = 'block';
            elem.style.display = 'none'
        }

        Sfjs.setPreference('toolbar/displayState', 'block');
    \">
        ";
        // line 17
        echo twig_include($this->env, $context, "@WebProfiler/Icon/symfony.svg");
        echo "
    </a>
</div>
<style>
    ";
        // line 21
        echo twig_include($this->env, $context, "@WebProfiler/Profiler/toolbar.css.twig", ["position" => (isset($context["position"]) || array_key_exists("position", $context) ? $context["position"] : (function () { throw new RuntimeError('Variable "position" does not exist.', 21, $this->source); })()), "floatable" => true]);
        echo "
</style>
<div id=\"sfToolbarClearer-";
        // line 23
        echo twig_escape_filter($this->env, (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 23, $this->source); })()), "html", null, true);
        echo "\" style=\"clear: both; height: 36px;\"></div>

<div id=\"sfToolbarMainContent-";
        // line 25
        echo twig_escape_filter($this->env, (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 25, $this->source); })()), "html", null, true);
        echo "\" class=\"sf-toolbarreset clear-fix\" data-no-turbolink>
    ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["templates"]) || array_key_exists("templates", $context) ? $context["templates"] : (function () { throw new RuntimeError('Variable "templates" does not exist.', 26, $this->source); })()));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["name"] => $context["template"]) {
            // line 27
            echo "        ";
            if (            $this->loadTemplate($context["template"], "@WebProfiler/Profiler/toolbar.html.twig", 27)->hasBlock("toolbar", $context)) {
                // line 28
                echo "            ";
                $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = ["collector" => twig_get_attribute($this->env, $this->source,                 // line 29
(isset($context["profile"]) || array_key_exists("profile", $context) ? $context["profile"] : (function () { throw new RuntimeError('Variable "profile" does not exist.', 29, $this->source); })()), "getcollector", [0 => $context["name"]], "method"), "profiler_url" =>                 // line 30
(isset($context["profiler_url"]) || array_key_exists("profiler_url", $context) ? $context["profiler_url"] : (function () { throw new RuntimeError('Variable "profiler_url" does not exist.', 30, $this->source); })()), "token" => twig_get_attribute($this->env, $this->source,                 // line 31
(isset($context["profile"]) || array_key_exists("profile", $context) ? $context["profile"] : (function () { throw new RuntimeError('Variable "profile" does not exist.', 31, $this->source); })()), "token", []), "name" =>                 // line 32
$context["name"], "profiler_markup_version" =>                 // line 33
(isset($context["profiler_markup_version"]) || array_key_exists("profiler_markup_version", $context) ? $context["profiler_markup_version"] : (function () { throw new RuntimeError('Variable "profiler_markup_version" does not exist.', 33, $this->source); })())];
                if (!twig_test_iterable($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4)) {
                    throw new RuntimeError('Variables passed to the "with" tag must be a hash.', 29, $this->getSourceContext());
                }
                $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = twig_to_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4);
                $context['_parent'] = $context;
                $context = $this->env->mergeGlobals(array_merge($context, $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4));
                // line 35
                echo "                ";
                $this->loadTemplate($context["template"], "@WebProfiler/Profiler/toolbar.html.twig", 35)->displayBlock("toolbar", $context);
                echo "
            ";
                $context = $context['_parent'];
                // line 37
                echo "        ";
            }
            // line 38
            echo "    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['name'], $context['template'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        echo "
    <a class=\"hide-button\" title=\"Close Toolbar\" tabindex=\"-1\" accesskey=\"D\" onclick=\"
        var p = this.parentNode;
        p.style.display = 'none';
        (p.previousElementSibling || p.previousSibling).style.display = 'none';
        document.getElementById('sfMiniToolbar-";
        // line 44
        echo twig_escape_filter($this->env, (isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 44, $this->source); })()), "html", null, true);
        echo "').style.display = 'block';
        Sfjs.setPreference('toolbar/displayState', 'none');
    \">
        ";
        // line 47
        echo twig_include($this->env, $context, "@WebProfiler/Icon/close.svg");
        echo "
    </a>
</div>
<!-- END of Symfony Web Debug Toolbar -->
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Profiler/toolbar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  162 => 47,  156 => 44,  149 => 39,  135 => 38,  132 => 37,  126 => 35,  118 => 33,  117 => 32,  116 => 31,  115 => 30,  114 => 29,  112 => 28,  109 => 27,  92 => 26,  88 => 25,  83 => 23,  78 => 21,  71 => 17,  62 => 11,  58 => 10,  52 => 7,  48 => 6,  41 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!-- START of Symfony Web Debug Toolbar -->
<div id=\"sfMiniToolbar-{{ token }}\" class=\"sf-minitoolbar\" data-no-turbolink>
    <a href=\"javascript:void(0);\" title=\"Show Symfony toolbar\" tabindex=\"-1\" accesskey=\"D\" onclick=\"
        var elem = this.parentNode;
        if (elem.style.display == 'none') {
            document.getElementById('sfToolbarMainContent-{{ token }}').style.display = 'none';
            document.getElementById('sfToolbarClearer-{{ token }}').style.display = 'none';
            elem.style.display = 'block';
        } else {
            document.getElementById('sfToolbarMainContent-{{ token }}').style.display = 'block';
            document.getElementById('sfToolbarClearer-{{ token }}').style.display = 'block';
            elem.style.display = 'none'
        }

        Sfjs.setPreference('toolbar/displayState', 'block');
    \">
        {{ include('@WebProfiler/Icon/symfony.svg') }}
    </a>
</div>
<style>
    {{ include('@WebProfiler/Profiler/toolbar.css.twig', { 'position': position, 'floatable': true }) }}
</style>
<div id=\"sfToolbarClearer-{{ token }}\" style=\"clear: both; height: 36px;\"></div>

<div id=\"sfToolbarMainContent-{{ token }}\" class=\"sf-toolbarreset clear-fix\" data-no-turbolink>
    {% for name, template in templates %}
        {% if block('toolbar', template) is defined %}
            {% with {
                collector: profile.getcollector(name),
                profiler_url: profiler_url,
                token: profile.token,
                name: name,
                profiler_markup_version: profiler_markup_version
              } %}
                {{ block('toolbar', template) }}
            {% endwith %}
        {% endif %}
    {% endfor %}

    <a class=\"hide-button\" title=\"Close Toolbar\" tabindex=\"-1\" accesskey=\"D\" onclick=\"
        var p = this.parentNode;
        p.style.display = 'none';
        (p.previousElementSibling || p.previousSibling).style.display = 'none';
        document.getElementById('sfMiniToolbar-{{ token }}').style.display = 'block';
        Sfjs.setPreference('toolbar/displayState', 'none');
    \">
        {{ include('@WebProfiler/Icon/close.svg') }}
    </a>
</div>
<!-- END of Symfony Web Debug Toolbar -->
", "@WebProfiler/Profiler/toolbar.html.twig", "/Applications/MAMP/htdocs/administration/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Profiler/toolbar.html.twig");
    }
}
