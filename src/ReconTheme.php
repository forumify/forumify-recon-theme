<?php

declare(strict_types=1);

namespace Forumify\ReconTheme;

use Forumify\ForumifyTheme;
use Forumify\Plugin\PluginMetadata;
use Forumify\Plugin\ThemeConfig;
use Forumify\Plugin\ThemeVar;
use Forumify\Plugin\ThemeVarType;

/**
 * A tactical HUD for milsim units and gaming clans: chamfered controls, corner brackets
 * and a map grid. Dark mode is night ops, light mode is a desert day.
 *
 * forumify's own variables keep their meaning, only their defaults change, so the admin
 * panel and every plugin pick up the palette. The recon-* variables drive the HUD details
 * in public/style.css and can be tuned under Admin → Settings → Themes.
 */
class ReconTheme extends ForumifyTheme
{
    /**
     * New defaults for forumify's own variables, as [light, dark].
     */
    private const OVERRIDES = [
        'c-primary' => ['#7a4a00', '#ffb000'],
        'c-primary-accent' => ['#a86200', '#ffc84a'],
        'c-primary-text' => ['#fbf6e8', '#14170f'],
        'c-secondary' => ['#55613d', '#4f5b3a'],
        'c-secondary-text' => ['#f3f0e2', '#e4e6da'],
        'c-call-to-action' => ['#b9252a', '#e5484d'],
        'c-call-to-action-accent' => ['#961c20', '#ff6369'],
        'c-call-to-action-text' => ['#ffffff', '#ffffff'],
        'c-text-primary' => ['#24271d', '#e4e6da'],
        'c-text-secondary' => ['#5c5e4b', '#9aa18c'],
        'c-success' => ['#d3e0bd', '#26381f'],
        'c-success-text' => ['#2c4419', '#b7e08d'],
        'c-info' => ['#d2dcd6', '#1f2f33'],
        'c-info-text' => ['#1f3a40', '#9fd0d9'],
        'c-warning' => ['#f0d9a4', '#3d3112'],
        'c-warning-text' => ['#5a3e00', '#ffd27a'],
        'c-error' => ['#efc7c3', '#3f1b1b'],
        'c-error-text' => ['#7a1717', '#ff9a9a'],
        'c-elevation-0' => ['#d9d2bc', '#171a15'],
        'c-elevation-1' => ['#ece6d4', '#20241d'],
        'c-elevation-2' => ['#e2dbc6', '#292e25'],
        'c-elevation-3' => ['#d7cfb8', '#32382d'],
        'c-elevation-4' => ['#cdc4ab', '#3a4135'],
        'c-elevation-5' => ['#c3b99e', '#434b3d'],
        'c-hover' => ['rgba(122, 74, 0, 0.07)', 'rgba(255, 176, 0, 0.06)'],
        'border-color' => ['rgba(36, 39, 29, 0.22)', 'rgba(228, 230, 218, 0.13)'],
        'border-radius' => ['0px', '0px'],
        'button-border-radius' => ['0px', '0px'],
        'font-size' => ['16px', '16px'],
    ];

    public function getPluginMetadata(): PluginMetadata
    {
        return new PluginMetadata(
            'Recon',
            'forumify',
            'A tactical HUD for milsim units and clans: chamfered panels, signal amber and a desert day mode.',
            'https://forumify.net',
        );
    }

    public function getThemeConfig(): ThemeConfig
    {
        $vars = array_map(static function (ThemeVar $var): ThemeVar {
            if (!isset(self::OVERRIDES[$var->key])) {
                return $var;
            }

            [$light, $dark] = self::OVERRIDES[$var->key];
            return new ThemeVar($var->key, $var->label, $var->type, $light, $dark, $var->help);
        }, parent::getThemeConfig()->vars);

        return new ThemeConfig(true, [
            ...$vars,
            new ThemeVar(
                'color-scheme',
                'Color Scheme',
                ThemeVarType::String,
                'light',
                'dark',
                'Tells the browser whether native controls and scrollbars should be light or dark.',
            ),
            new ThemeVar('recon-signal', 'Signal Color', ThemeVarType::Color, '#a86200', '#ffb000', 'Corner brackets, active states and the HUD line under the header.'),
            new ThemeVar('recon-signal-text', 'Signal Text Color', ThemeVarType::Color, '#fff8e6', '#14170f'),
            new ThemeVar('recon-grid', 'Map Grid', ThemeVarType::Color, 'rgba(36, 39, 29, 0.07)', 'rgba(228, 230, 218, 0.04)', 'Colour of the grid behind the page. Use transparent to hide it.'),
            new ThemeVar('recon-grid-size', 'Map Grid Size', ThemeVarType::Size, '48px', '48px'),
            new ThemeVar('recon-chamfer', 'Chamfer', ThemeVarType::Size, '10px', '10px', 'How much is cut off the corners of buttons and tags.'),
            new ThemeVar('recon-bracket', 'Bracket Size', ThemeVarType::Size, '14px', '14px', 'Length of the corner brackets on panels.'),
            new ThemeVar('recon-display-font', 'Display Font', ThemeVarType::String, "'Chakra Petch', sans-serif"),
            new ThemeVar('recon-font', 'Body Font', ThemeVarType::String, "'Barlow', sans-serif"),
        ]);
    }

    /**
     * Stylesheets loaded on every page while the theme is active, relative to public/.
     *
     * @return array<string>
     */
    public function getStylesheets(): array
    {
        return ['style.css'];
    }
}
