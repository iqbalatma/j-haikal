<?php

namespace App\View\Components\Layouts\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\Component;

class PageHeader extends Component
{
    public string $lastBreadcrumbKey;
    public string $_pageTitle;
    public string $_pageSubTitle;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $sharedView = FacadesView::getShared();

        $breadcrumbs = array_keys($sharedView["breadcrumbs"]);
        $this->lastBreadcrumbKey = end($breadcrumbs);
        $this->_pageTitle = $sharedView["pageTitle"] ?? "";
        $this->_pageSubTitle = $sharedView["pageSubTitle"] ?? "";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.dashboard.page-header');
    }
}
