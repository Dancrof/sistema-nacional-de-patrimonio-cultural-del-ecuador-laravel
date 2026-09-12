<?php

namespace Tests\Feature\AdminLte;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelCustomizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_panel_uses_project_branding_and_real_module_menu(): void
    {
        $this->assertSame('Patrimonio Ecuador', config('adminlte.title'));
        $this->assertSame('Patrimonio Ecuador', config('adminlte.logo'));

        $menu = config('adminlte.menu');
        $menuTexts = collect($menu)->pluck('text')->all();

        $this->assertContains('Dashboard', $menuTexts);
        $this->assertContains('Obras', $menuTexts);
        $this->assertContains('Artistas', $menuTexts);
        $this->assertContains('Usuarios', $menuTexts);
        $this->assertNotContains('Dashboard v1', $menuTexts);
        $this->assertNotContains('Theme Generate', $menuTexts);
        $this->assertNotContains('Widgets', $menuTexts);
    }
}
