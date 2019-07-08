<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if ('/_profiler' === rtrim($pathinfo, '/')) {
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                        goto not__profiler_home;
                    } else {
                        return $this->redirect($rawPathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }
                not__profiler_home:

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ('/_profiler/search' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ('/_profiler/search_bar' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ('/_profiler/purge' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ('/_profiler/phpinfo' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        // nb_main_homepage
        if ('' === rtrim($pathinfo, '/')) {
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif (!in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                goto not_nb_main_homepage;
            } else {
                return $this->redirect($rawPathinfo.'/', 'nb_main_homepage');
            }

            return array (  '_controller' => 'NB\\MainBundle\\Controller\\MainController::indexAction',  '_route' => 'nb_main_homepage',);
        }
        not_nb_main_homepage:

        if (0 === strpos($pathinfo, '/compagnie')) {
            // nb_main_liste_des_compagnie
            if ('/compagnie/liste-des-compagnie' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\CompagnieController::listAction',  '_route' => 'nb_main_liste_des_compagnie',);
            }

            // nb_main_ajouter_compagnie
            if ('/compagnie/ajouter-une-compagnie' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\CompagnieController::addAction',  '_route' => 'nb_main_ajouter_compagnie',);
            }

            // nb_main_modifier_compagnie
            if (0 === strpos($pathinfo, '/compagnie/modifier-une-compagnie') && preg_match('#^/compagnie/modifier\\-une\\-compagnie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_compagnie')), array (  '_controller' => 'NB\\MainBundle\\Controller\\CompagnieController::editAction',));
            }

            // nb_main_supprimer_compagnie
            if (0 === strpos($pathinfo, '/compagnie/supprimer-une-compagnie') && preg_match('#^/compagnie/supprimer\\-une\\-compagnie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_supprimer_compagnie')), array (  '_controller' => 'NB\\MainBundle\\Controller\\CompagnieController::deleteAction',));
            }

            if (0 === strpos($pathinfo, '/compagnie/liste-utilisateur-compagnie')) {
                // nb_main_liste_utilisateur_compagnie
                if (preg_match('#^/compagnie/liste\\-utilisateur\\-compagnie/(?P<compagnie_id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_liste_utilisateur_compagnie')), array (  '_controller' => 'NB\\MainBundle\\Controller\\CompagnieController::usersAction',));
                }

                // nb_main_ajouter_compagnie_utilisateur
                if (preg_match('#^/compagnie/liste\\-utilisateur\\-compagnie/(?P<compagnie_id>[^/]++)/nouveau$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_ajouter_compagnie_utilisateur')), array (  '_controller' => 'NB\\MainBundle\\Controller\\CompagnieController::usersAddAction',));
                }

            }

        }

        if (0 === strpos($pathinfo, '/s')) {
            // nb_main_liste_seatseller
            if ('/seatSeller/liste-seatseller' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\SeatSellerController::listAction',  '_route' => 'nb_main_liste_seatseller',);
            }

            // nb_main_statistique_seatseller
            if ('/statistiques/seatseller' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\StatistiquesController::seatsellerAction',  '_route' => 'nb_main_statistique_seatseller',);
            }

            if (0 === strpos($pathinfo, '/seat')) {
                if (0 === strpos($pathinfo, '/seatSeller')) {
                    // nb_main_ajouter_seatseller
                    if ('/seatSeller/nouveau-seatseller' === $pathinfo) {
                        return array (  '_controller' => 'NB\\MainBundle\\Controller\\SeatSellerController::addAction',  '_route' => 'nb_main_ajouter_seatseller',);
                    }

                    // nb_main_modifier_seatseller
                    if (0 === strpos($pathinfo, '/seatSeller/modifier-seatseller') && preg_match('#^/seatSeller/modifier\\-seatseller/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_seatseller')), array (  '_controller' => 'NB\\MainBundle\\Controller\\SeatSellerController::editAction',));
                    }

                    // nb_main_liste_utilisateur_seatseller
                    if (0 === strpos($pathinfo, '/seatSeller/utilisateur-seatseller') && preg_match('#^/seatSeller/utilisateur\\-seatseller/(?P<seatseller_id>[^/]++)$#sD', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_liste_utilisateur_seatseller')), array (  '_controller' => 'NB\\MainBundle\\Controller\\SeatSellerController::usersAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/seatseller')) {
                    // nb_main_seatseller_users_nouveau
                    if (preg_match('#^/seatseller/(?P<seatseller_id>[^/]++)/utilisateurs/nouveau$#sD', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_seatseller_users_nouveau')), array (  '_controller' => 'NB\\MainBundle\\Controller\\SeatSellerController::usersAddAction',));
                    }

                    // nb_main_seatseller_solde_compte
                    if (preg_match('#^/seatseller/(?P<seatseller_id>[^/]++)/account$#sD', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_seatseller_solde_compte')), array (  '_controller' => 'NB\\MainBundle\\Controller\\SeatSellerController::accountAction',));
                    }

                }

            }

        }

        if (0 === strpos($pathinfo, '/axes')) {
            // nb_main_liste_des_axes
            if ('/axes/liste-des-axes' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\AxesController::listAction',  '_route' => 'nb_main_liste_des_axes',);
            }

            // nb_main_ajouter_axes
            if ('/axes/ajouter-des-axes' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\AxesController::addAction',  '_route' => 'nb_main_ajouter_axes',);
            }

            // nb_main_modifier_axes
            if (0 === strpos($pathinfo, '/axes/modifier-un-axe') && preg_match('#^/axes/modifier\\-un\\-axe/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_axes')), array (  '_controller' => 'NB\\MainBundle\\Controller\\AxesController::editAction',));
            }

        }

        if (0 === strpos($pathinfo, '/v')) {
            if (0 === strpos($pathinfo, '/vil')) {
                // nb_main_liste_des_villes
                if ('/villes/liste-des-villes' === $pathinfo) {
                    return array (  '_controller' => 'NB\\MainBundle\\Controller\\VillesController::listAction',  '_route' => 'nb_main_liste_des_villes',);
                }

                // nb_main_ajouter_des_villes
                if ('/viles/ajouter-une-ville' === $pathinfo) {
                    return array (  '_controller' => 'NB\\MainBundle\\Controller\\VillesController::addAction',  '_route' => 'nb_main_ajouter_des_villes',);
                }

                // nb_main_modifier_villes
                if (0 === strpos($pathinfo, '/villes/modifier-une-ville') && preg_match('#^/villes/modifier\\-une\\-ville/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_villes')), array (  '_controller' => 'NB\\MainBundle\\Controller\\VillesController::editAction',));
                }

            }

            if (0 === strpos($pathinfo, '/voyages')) {
                // nb_main_liste_des_voyages
                if ('/voyages/liste-des-voyages' === $pathinfo) {
                    return array (  '_controller' => 'NB\\MainBundle\\Controller\\VoyagesController::listAction',  '_route' => 'nb_main_liste_des_voyages',);
                }

                // nb_main_ajouter_des_voyages
                if ('/voyages/ajouter-des-voyages' === $pathinfo) {
                    return array (  '_controller' => 'NB\\MainBundle\\Controller\\VoyagesController::addAction',  '_route' => 'nb_main_ajouter_des_voyages',);
                }

                // nb_main_modifier_voyages
                if (0 === strpos($pathinfo, '/voyages/modifier-un-voyage') && preg_match('#^/voyages/modifier\\-un\\-voyage/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_voyages')), array (  '_controller' => 'NB\\MainBundle\\Controller\\VoyagesController::editAction',));
                }

                if (0 === strpos($pathinfo, '/voyages/point-embarquement')) {
                    // nb_main_liste_des_point_embarquement
                    if ('/voyages/point-embarquement' === $pathinfo) {
                        return array (  '_controller' => 'NB\\MainBundle\\Controller\\PointController::listAction',  '_route' => 'nb_main_liste_des_point_embarquement',);
                    }

                    // nb_main_ajouter_des_point_embarquement
                    if ('/voyages/point-embarquement/nouveau' === $pathinfo) {
                        return array (  '_controller' => 'NB\\MainBundle\\Controller\\PointController::addAction',  '_route' => 'nb_main_ajouter_des_point_embarquement',);
                    }

                }

                // nb_main_modifier_des_point_embarquement
                if (0 === strpos($pathinfo, '/voyages/modifier-point-embarquement') && preg_match('#^/voyages/modifier\\-point\\-embarquement/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_des_point_embarquement')), array (  '_controller' => 'NB\\MainBundle\\Controller\\PointController::editAction',));
                }

            }

        }

        if (0 === strpos($pathinfo, '/promotions')) {
            // nb_main_liste_gestion_des_promotions
            if ('/promotions/liste-gestion-des-promotions' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\PromotionsController::listAction',  '_route' => 'nb_main_liste_gestion_des_promotions',);
            }

            // nb_main_ajouter_gestion_des_promotions
            if ('/promotions/ajouter-gestion-des-promotions' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\PromotionsController::addAction',  '_route' => 'nb_main_ajouter_gestion_des_promotions',);
            }

            // nb_main_modifier_gestion_des_promotions
            if (0 === strpos($pathinfo, '/promotions/modifier-une-promotion') && preg_match('#^/promotions/modifier\\-une\\-promotion/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_gestion_des_promotions')), array (  '_controller' => 'NB\\MainBundle\\Controller\\PromotionsController::editAction',));
            }

        }

        if (0 === strpos($pathinfo, '/termes_conditions')) {
            // nb_main_liste_termes_et_conditions
            if ('/termes_conditions/liste-termes-et-conditions' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:TermesConditions:list',  '_route' => 'nb_main_liste_termes_et_conditions',);
            }

            // nb_main_modifier_termes_et_conditions
            if (0 === strpos($pathinfo, '/termes_conditions/modifier-termes-et-conditions') && preg_match('#^/termes_conditions/modifier\\-termes\\-et\\-conditions/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_termes_et_conditions')), array (  '_controller' => 'NBMainBundle:TermesConditions:edit',));
            }

        }

        if (0 === strpos($pathinfo, '/confidentialite')) {
            // nb_main_liste_de_confidentialite
            if ('/confidentialite/liste-des-confidentialites' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:Confidentialite:list',  '_route' => 'nb_main_liste_de_confidentialite',);
            }

            // nb_main_modifier_confidentialite
            if (0 === strpos($pathinfo, '/confidentialite/modifier-confidentialites') && preg_match('#^/confidentialite/modifier\\-confidentialites/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'nb_main_modifier_confidentialite')), array (  '_controller' => 'NBMainBundle:Confidentialite:edit',));
            }

        }

        if (0 === strpos($pathinfo, '/blog')) {
            // nb_main_liste_blog
            if ('/blog/liste-blog' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:Blog:list',  '_route' => 'nb_main_liste_blog',);
            }

            // nb_main_modifier_blog
            if ('/blog/modifier-blog' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:Blog:edit',  '_route' => 'nb_main_modifier_blog',);
            }

        }

        if (0 === strpos($pathinfo, '/professionel')) {
            // nb_main_liste_professionel
            if ('/professionel/liste-professionel' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:Professionel:list',  '_route' => 'nb_main_liste_professionel',);
            }

            // nb_main_modifier_professionel
            if ('/professionel/modifier-professionel' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:Professionel:edit',  '_route' => 'nb_main_modifier_professionel',);
            }

        }

        if (0 === strpos($pathinfo, '/modif_voyage')) {
            // nb_main_liste_modification_voyage
            if ('/modif_voyage/liste-modification-voyage' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:ModificationVoyage:list',  '_route' => 'nb_main_liste_modification_voyage',);
            }

            // nb_main_modifier_modification_voyage
            if ('/modif_voyage/modifier-modification-voyage' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:ModificationVoyage:edit',  '_route' => 'nb_main_modifier_modification_voyage',);
            }

        }

        if (0 === strpos($pathinfo, '/annul_voyage')) {
            // nb_main_liste_annulation_voyage
            if ('/annul_voyage/liste-annulation-voyage' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:AnnulationVoyage:list',  '_route' => 'nb_main_liste_annulation_voyage',);
            }

            // nb_main_modifier_annulation_voyage
            if ('/annul_voyage/modifier-annulation-voyage' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:annulationVoyage:edit',  '_route' => 'nb_main_modifier_annulation_voyage',);
            }

        }

        if (0 === strpos($pathinfo, '/cms')) {
            // nb_main_termes_et_conditions
            if ('/cms/termes-et-conditions' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\CMSController::TermesConditionsAction',  '_route' => 'nb_main_termes_et_conditions',);
            }

            // nb_main_confidentialite
            if ('/cms/confidentialites' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\CMSController::ConfidentialiteAction',  '_route' => 'nb_main_confidentialite',);
            }

            // nb_main_blog
            if ('/cms/blog' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\CMSController::BlogAction',  '_route' => 'nb_main_blog',);
            }

            // nb_main_professionel
            if ('/cms/professionel' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\CMSController::ProfessionelAction',  '_route' => 'nb_main_professionel',);
            }

            // nb_main_modification_voyage
            if ('/cms/modification-voyage' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\CMSController::ModificationVoyageAction',  '_route' => 'nb_main_modification_voyage',);
            }

            // nb_main_annulation_voyage
            if ('/cms/annulation-voyage' === $pathinfo) {
                return array (  '_controller' => 'NB\\MainBundle\\Controller\\CMSController::AnnulationVoyageAction',  '_route' => 'nb_main_annulation_voyage',);
            }

        }

        if (0 === strpos($pathinfo, '/gest_newsletter')) {
            // nb_main_liste_gestion_newsletter
            if ('/gest_newsletter/liste-gestion-newsletter' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:GestionNewsletter:list',  '_route' => 'nb_main_liste_gestion_newsletter',);
            }

            // nb_main_modifier_gestion_newsletter
            if ('/gest_newsletter/modifier-gestion-newsletter' === $pathinfo) {
                return array (  '_controller' => 'NBMainBundle:GestionNewsletter:edit',  '_route' => 'nb_main_modifier_gestion_newsletter',);
            }

        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // login
                if ('/login' === $pathinfo) {
                    return array (  '_controller' => 'NB\\UsersBundle\\Controller\\SecurityController::loginAction',  '_route' => 'login',);
                }

                // login_check
                if ('/login_check' === $pathinfo) {
                    return array('_route' => 'login_check');
                }

            }

            // logout
            if ('/logout' === $pathinfo) {
                return array('_route' => 'logout');
            }

            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ('/login' === $pathinfo) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_login;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }
                not_fos_user_security_login:

                // fos_user_security_check
                if ('/login_check' === $pathinfo) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ('/logout' === $pathinfo) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_security_logout;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }
            not_fos_user_security_logout:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
