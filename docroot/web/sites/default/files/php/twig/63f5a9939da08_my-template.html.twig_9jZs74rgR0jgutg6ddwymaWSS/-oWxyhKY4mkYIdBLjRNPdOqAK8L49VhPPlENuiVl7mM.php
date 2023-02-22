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

/* modules/dependency_injection_services/templates/my-template.html.twig */
class __TwigTemplate_00d0729311ddccb2ac6394f9d3963767 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<table>
\t<tr>
\t\t<th>S.No</th>
\t\t<th>Name</th>
\t\t<th>Father Name</th>
\t\t<th>Email Id</th>
\t\t<th>Contact</th>
\t\t<th>Edit</th>
\t\t<th>Delete</th>
\t</tr>
\t";
        // line 11
        $context["count"] = 0;
        // line 12
        echo "\t";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["data"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 13
            echo "\t\t";
            $context["count"] = (($context["count"] ?? null) + 1);
            // line 14
            echo "\t\t<tr>
\t\t\t<td>";
            // line 15
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["count"] ?? null), 15, $this->source), "html", null, true);
            echo "</td>
\t\t\t<td>";
            // line 16
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["value"], "name", [], "any", false, false, true, 16), 16, $this->source), "html", null, true);
            echo "</td>
\t\t\t<td>";
            // line 17
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["value"], "father_name", [], "any", false, false, true, 17), 17, $this->source), "html", null, true);
            echo "</td>
\t\t\t<td>";
            // line 18
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["value"], "mail", [], "any", false, false, true, 18), 18, $this->source), "html", null, true);
            echo "</td>
\t\t\t<td>";
            // line 19
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["value"], "phone", [], "any", false, false, true, 19), 19, $this->source), "html", null, true);
            echo "</td>
\t\t\t<td>
\t\t\t\t<a href='edit_user/";
            // line 21
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["value"], "id", [], "any", false, false, true, 21), 21, $this->source), "html", null, true);
            echo "'>Edit</a>
\t\t\t</td>
\t\t\t<td>
\t\t\t\t<a href='delete_user/";
            // line 24
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["value"], "id", [], "any", false, false, true, 24), 24, $this->source), "html", null, true);
            echo "'>Delete</a>
\t\t\t</td>
\t\t</tr>
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo "</table>
";
    }

    public function getTemplateName()
    {
        return "modules/dependency_injection_services/templates/my-template.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 28,  91 => 24,  85 => 21,  80 => 19,  76 => 18,  72 => 17,  68 => 16,  64 => 15,  61 => 14,  58 => 13,  53 => 12,  51 => 11,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/dependency_injection_services/templates/my-template.html.twig", "/var/www/web/modules/dependency_injection_services/templates/my-template.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 11, "for" => 12);
        static $filters = array("escape" => 15);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'for'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
