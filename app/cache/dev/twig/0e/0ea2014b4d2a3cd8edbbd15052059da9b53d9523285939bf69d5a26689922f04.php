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

/* @WebProfiler/Collector/events.html.twig */
class __TwigTemplate_1f4d0124ccad6bec9321052b4e707283fbad7988eadd07e3754f3e5a5c3f1f70 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'menu' => [$this, 'block_menu'],
            'panel' => [$this, 'block_panel'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/events.html.twig"));

        // line 3
        $context["helper"] = $this;
        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/events.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/event.svg");
        echo "</span>
    <strong>Events</strong>
</span>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = [])
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    <h2>Event Dispatcher</h2>

    ";
        // line 15
        if (twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 15, $this->source); })()), "calledlisteners", []))) {
            // line 16
            echo "        <div class=\"empty\">
            <p>No events have been recorded. Check that debugging is enabled in the kernel.</p>
        </div>
    ";
        } else {
            // line 20
            echo "        <div class=\"sf-tabs\">
            <div class=\"tab\">
                <h3 class=\"tab-title\">Called Listeners <span class=\"badge\">";
            // line 22
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 22, $this->source); })()), "calledlisteners", [])), "html", null, true);
            echo "</span></h3>

                <div class=\"tab-content\">
                    ";
            // line 25
            echo $context["helper"]->macro_render_table(twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 25, $this->source); })()), "calledlisteners", []));
            echo "
                </div>
            </div>

            <div class=\"tab\">
                <h3 class=\"tab-title\">Not Called Listeners <span class=\"badge\">";
            // line 30
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 30, $this->source); })()), "notcalledlisteners", [])), "html", null, true);
            echo "</span></h3>
                <div class=\"tab-content\">
                    ";
            // line 32
            if (twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 32, $this->source); })()), "notcalledlisteners", []))) {
                // line 33
                echo "                        <div class=\"empty\">
                            <p>
                                <strong>There are no uncalled listeners</strong>.
                            </p>
                            <p>
                                All listeners were called for this request or an error occurred
                                when trying to collect uncalled listeners (in which case check the
                                logs to get more information).
                            </p>
                        </div>
                    ";
            } else {
                // line 44
                echo "                        ";
                echo $context["helper"]->macro_render_table(twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 44, $this->source); })()), "notcalledlisteners", []));
                echo "
                    ";
            }
            // line 46
            echo "                </div>
            </div>
        </div>
    ";
        }
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 52
    public function macro_render_table($__listeners__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals([
            "listeners" => $__listeners__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start();
        try {
            $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
            $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "macro", "render_table"));

            // line 53
            echo "    <table>
        <thead>
            <tr>
                <th class=\"text-right\">Priority</th>
                <th>Listener</th>
            </tr>
        </thead>

        ";
            // line 61
            $context["previous_event"] = twig_get_attribute($this->env, $this->source, twig_first($this->env, (isset($context["listeners"]) || array_key_exists("listeners", $context) ? $context["listeners"] : (function () { throw new RuntimeError('Variable "listeners" does not exist.', 61, $this->source); })())), "event", []);
            // line 62
            echo "        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["listeners"]) || array_key_exists("listeners", $context) ? $context["listeners"] : (function () { throw new RuntimeError('Variable "listeners" does not exist.', 62, $this->source); })()));
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
            foreach ($context['_seq'] as $context["_key"] => $context["listener"]) {
                // line 63
                echo "            ";
                if ((twig_get_attribute($this->env, $this->source, $context["loop"], "first", []) || (twig_get_attribute($this->env, $this->source, $context["listener"], "event", []) != (isset($context["previous_event"]) || array_key_exists("previous_event", $context) ? $context["previous_event"] : (function () { throw new RuntimeError('Variable "previous_event" does not exist.', 63, $this->source); })())))) {
                    // line 64
                    echo "                ";
                    if ( !twig_get_attribute($this->env, $this->source, $context["loop"], "first", [])) {
                        // line 65
                        echo "                    </tbody>
                ";
                    }
                    // line 67
                    echo "
                <tbody>
                    <tr>
                        <th colspan=\"2\" class=\"colored font-normal\">";
                    // line 70
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "event", []), "html", null, true);
                    echo "</th>
                    </tr>

                ";
                    // line 73
                    $context["previous_event"] = twig_get_attribute($this->env, $this->source, $context["listener"], "event", []);
                    // line 74
                    echo "            ";
                }
                // line 75
                echo "
            <tr>
                <td class=\"text-right nowrap\">";
                // line 77
                echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, $context["listener"], "priority", [], "any", true, true)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, $context["listener"], "priority", []), "-")) : ("-")), "html", null, true);
                echo "</td>
                <td class=\"font-normal\">
                    ";
                // line 79
                if ((twig_get_attribute($this->env, $this->source, $context["listener"], "type", []) == "Closure")) {
                    // line 80
                    echo "
                        Closure
                        <span class=\"text-muted text-small\">(there is no class or file information)</span>

                    ";
                } elseif ((twig_get_attribute($this->env, $this->source,                 // line 84
$context["listener"], "type", []) == "Function")) {
                    // line 85
                    echo "
                        ";
                    // line 86
                    $context["link"] = $this->extensions['Symfony\Bridge\Twig\Extension\CodeExtension']->getFileLink(twig_get_attribute($this->env, $this->source, $context["listener"], "file", []), twig_get_attribute($this->env, $this->source, $context["listener"], "line", []));
                    // line 87
                    echo "                        ";
                    if ((isset($context["link"]) || array_key_exists("link", $context) ? $context["link"] : (function () { throw new RuntimeError('Variable "link" does not exist.', 87, $this->source); })())) {
                        // line 88
                        echo "                            <a href=\"";
                        echo twig_escape_filter($this->env, (isset($context["link"]) || array_key_exists("link", $context) ? $context["link"] : (function () { throw new RuntimeError('Variable "link" does not exist.', 88, $this->source); })()), "html", null, true);
                        echo "\">";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "function", []), "html", null, true);
                        echo "()</a>
                            <span class=\"text-muted text-small\">(";
                        // line 89
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "file", []), "html", null, true);
                        echo ")</span>
                        ";
                    } else {
                        // line 91
                        echo "                            ";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "function", []), "html", null, true);
                        echo "()
                            <span class=\"text-muted newline text-small\">";
                        // line 92
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "file", []), "html", null, true);
                        echo " (line ";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "line", []), "html", null, true);
                        echo ")</span>
                        ";
                    }
                    // line 94
                    echo "
                    ";
                } elseif ((twig_get_attribute($this->env, $this->source,                 // line 95
$context["listener"], "type", []) == "Method")) {
                    // line 96
                    echo "
                        ";
                    // line 97
                    $context["link"] = $this->extensions['Symfony\Bridge\Twig\Extension\CodeExtension']->getFileLink(twig_get_attribute($this->env, $this->source, $context["listener"], "file", []), twig_get_attribute($this->env, $this->source, $context["listener"], "line", []));
                    // line 98
                    echo "                        ";
                    $context["class_namespace"] = twig_join_filter(twig_split_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "class", []), "\\",  -1), "\\");
                    // line 99
                    echo "
                        ";
                    // line 100
                    if ((isset($context["link"]) || array_key_exists("link", $context) ? $context["link"] : (function () { throw new RuntimeError('Variable "link" does not exist.', 100, $this->source); })())) {
                        // line 101
                        echo "                            <a href=\"";
                        echo twig_escape_filter($this->env, (isset($context["link"]) || array_key_exists("link", $context) ? $context["link"] : (function () { throw new RuntimeError('Variable "link" does not exist.', 101, $this->source); })()), "html", null, true);
                        echo "\"><strong>";
                        echo twig_escape_filter($this->env, strip_tags($this->extensions['Symfony\Bridge\Twig\Extension\CodeExtension']->abbrClass(twig_get_attribute($this->env, $this->source, $context["listener"], "class", []))), "html", null, true);
                        echo "</strong>::";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "method", []), "html", null, true);
                        echo "()</a>
                            <span class=\"text-muted text-small\">(";
                        // line 102
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "class", []), "html", null, true);
                        echo ")</span>
                        ";
                    } else {
                        // line 104
                        echo "                            <span>";
                        echo twig_escape_filter($this->env, (isset($context["class_namespace"]) || array_key_exists("class_namespace", $context) ? $context["class_namespace"] : (function () { throw new RuntimeError('Variable "class_namespace" does not exist.', 104, $this->source); })()), "html", null, true);
                        echo "\\</span><strong>";
                        echo twig_escape_filter($this->env, strip_tags($this->extensions['Symfony\Bridge\Twig\Extension\CodeExtension']->abbrClass(twig_get_attribute($this->env, $this->source, $context["listener"], "class", []))), "html", null, true);
                        echo "</strong>::";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "method", []), "html", null, true);
                        echo "()
                            <span class=\"text-muted newline text-small\">";
                        // line 105
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "file", []), "html", null, true);
                        echo " (line ";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["listener"], "line", []), "html", null, true);
                        echo ")</span>
                        ";
                    }
                    // line 107
                    echo "
                    ";
                }
                // line 109
                echo "                </td>
            </tr>

            ";
                // line 112
                if (twig_get_attribute($this->env, $this->source, $context["loop"], "last", [])) {
                    // line 113
                    echo "                </tbody>
            ";
                }
                // line 115
                echo "        ";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['listener'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 116
            echo "    </table>
";
            
            $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);


            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/events.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  346 => 116,  332 => 115,  328 => 113,  326 => 112,  321 => 109,  317 => 107,  310 => 105,  301 => 104,  296 => 102,  287 => 101,  285 => 100,  282 => 99,  279 => 98,  277 => 97,  274 => 96,  272 => 95,  269 => 94,  262 => 92,  257 => 91,  252 => 89,  245 => 88,  242 => 87,  240 => 86,  237 => 85,  235 => 84,  229 => 80,  227 => 79,  222 => 77,  218 => 75,  215 => 74,  213 => 73,  207 => 70,  202 => 67,  198 => 65,  195 => 64,  192 => 63,  174 => 62,  172 => 61,  162 => 53,  147 => 52,  136 => 46,  130 => 44,  117 => 33,  115 => 32,  110 => 30,  102 => 25,  96 => 22,  92 => 20,  86 => 16,  84 => 15,  80 => 13,  74 => 12,  63 => 7,  60 => 6,  54 => 5,  46 => 1,  44 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% import _self as helper %}

{% block menu %}
<span class=\"label\">
    <span class=\"icon\">{{ include('@WebProfiler/Icon/event.svg') }}</span>
    <strong>Events</strong>
</span>
{% endblock %}

{% block panel %}
    <h2>Event Dispatcher</h2>

    {% if collector.calledlisteners is empty %}
        <div class=\"empty\">
            <p>No events have been recorded. Check that debugging is enabled in the kernel.</p>
        </div>
    {% else %}
        <div class=\"sf-tabs\">
            <div class=\"tab\">
                <h3 class=\"tab-title\">Called Listeners <span class=\"badge\">{{ collector.calledlisteners|length }}</span></h3>

                <div class=\"tab-content\">
                    {{ helper.render_table(collector.calledlisteners) }}
                </div>
            </div>

            <div class=\"tab\">
                <h3 class=\"tab-title\">Not Called Listeners <span class=\"badge\">{{ collector.notcalledlisteners|length }}</span></h3>
                <div class=\"tab-content\">
                    {% if collector.notcalledlisteners is empty %}
                        <div class=\"empty\">
                            <p>
                                <strong>There are no uncalled listeners</strong>.
                            </p>
                            <p>
                                All listeners were called for this request or an error occurred
                                when trying to collect uncalled listeners (in which case check the
                                logs to get more information).
                            </p>
                        </div>
                    {% else %}
                        {{ helper.render_table(collector.notcalledlisteners) }}
                    {% endif %}
                </div>
            </div>
        </div>
    {% endif %}
{% endblock %}

{% macro render_table(listeners) %}
    <table>
        <thead>
            <tr>
                <th class=\"text-right\">Priority</th>
                <th>Listener</th>
            </tr>
        </thead>

        {% set previous_event = (listeners|first).event %}
        {% for listener in listeners %}
            {% if loop.first or listener.event != previous_event %}
                {% if not loop.first %}
                    </tbody>
                {% endif %}

                <tbody>
                    <tr>
                        <th colspan=\"2\" class=\"colored font-normal\">{{ listener.event }}</th>
                    </tr>

                {% set previous_event = listener.event %}
            {% endif %}

            <tr>
                <td class=\"text-right nowrap\">{{ listener.priority|default('-') }}</td>
                <td class=\"font-normal\">
                    {% if listener.type == 'Closure' %}

                        Closure
                        <span class=\"text-muted text-small\">(there is no class or file information)</span>

                    {% elseif listener.type == 'Function' %}

                        {% set link = listener.file|file_link(listener.line) %}
                        {% if link %}
                            <a href=\"{{ link }}\">{{ listener.function }}()</a>
                            <span class=\"text-muted text-small\">({{ listener.file }})</span>
                        {% else %}
                            {{ listener.function }}()
                            <span class=\"text-muted newline text-small\">{{ listener.file }} (line {{ listener.line }})</span>
                        {% endif %}

                    {% elseif listener.type == \"Method\" %}

                        {% set link = listener.file|file_link(listener.line) %}
                        {% set class_namespace = listener.class|split('\\\\', -1)|join('\\\\') %}

                        {% if link %}
                            <a href=\"{{ link }}\"><strong>{{ listener.class|abbr_class|striptags }}</strong>::{{ listener.method }}()</a>
                            <span class=\"text-muted text-small\">({{ listener.class }})</span>
                        {% else %}
                            <span>{{ class_namespace }}\\</span><strong>{{ listener.class|abbr_class|striptags }}</strong>::{{ listener.method }}()
                            <span class=\"text-muted newline text-small\">{{ listener.file }} (line {{ listener.line }})</span>
                        {% endif %}

                    {% endif %}
                </td>
            </tr>

            {% if loop.last %}
                </tbody>
            {% endif %}
        {% endfor %}
    </table>
{% endmacro %}
", "@WebProfiler/Collector/events.html.twig", "/Applications/MAMP/htdocs/administration/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Collector/events.html.twig");
    }
}
