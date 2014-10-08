<?php
/**
 * A page with content in many articles.
 * An aside with navigation to the headings in the articles.
 * 
 * @author Rikard Karlsson
 * @version 13-11-03
 */
class CArticleAndAside {
	private $articles;
	private $noArticles;
	
	public function __constuctor() {
		$this->articles = array();
	}
	
	public function addArticle($articleHtml, $linkText)
	{
		$this->articles[$this->noArticles] = array('linkText' => $linkText, 'articleHtml' => $articleHtml);
		++$this->noArticles;
	}
	
	public function getArticleHtml() {
		$html = "<section>";
		for ($articleId = 0; $articleId < $noArticles; ++$articleId) {
			$html .= "<article id= '". $articleId . "'>" .
					$this->articleHtml;
					"</article>";
		}
		$html .= "</section>";
		return $html;
	}
	
	public function getNavHtml() {
		$html = "<aside>" .
                "<ul>";
		for ($articleId = 0; $articleId < $noArticles; ++$articleId) {
			
		}
		
		
		return $html;
	}
}