<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Base\BaseController;
use App\StaticPage;
use Illuminate\Http\Request;
use Session;

class HelpController extends BaseController {

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit() {
        $page = StaticPage::where('page', 'help')->first();
        return view('admin.help.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request) {
        $this->validate($request, [
            'content' => 'min:3|required',
        ]);

        StaticPage::where('page', 'help')->update(['content' => $request->content]);
        
        Session::flash('message', 'Update successfuly');

        return redirect('backend/help');
    }
}
