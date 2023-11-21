<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Article;

class Articles extends BaseController
{
    protected $path = 'articles/';
    public function index() {
        $article = new Article();
        $title['Title'] = 'Knowledge Base';
        $title['subMenu'] = 'Back';
        $title['subMenuPath'] = $this->path;

        $data['page'] = emp_page([$title, $this->path.'index']);
        $data['articles'] = $article->show('publish');
        return view('app', $data);
    }

    public function show($id) {

        $title['Title'] = 'Knowledge Base';
        $title['subMenu'] = 'Back';
        $title['subMenuPath'] = $this->path;

        $article = new Article();
        $data['article'] = $article->where('id',$id)->first();
        $data['page'] = emp_page([$title,$this->path.'show']);
        return view('app',$data);
    }
}
