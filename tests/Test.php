<?php

namespace My\Project;

use My\Project\TextFormatter\Bundle as TextFormatter;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
	/**
	* @dataProvider getParseRenderTests()
	*/
	public function testParseRender($text, $expected)
	{
		$xml  = TextFormatter::parse($text);
		$html = TextFormatter::render($xml);

		$this->assertEquals($expected, $html);
	}

	public function getParseRenderTests()
	{
		return [
			[
				"line 1\nline2",
				"<p>line 1<br>\nline2</p>",
			],
			[
				'[b]..[/b]',
				'<p><b>..</b></p>'
			],
			[
				'[x](/x)',
				'<p><a href="/x">x</a></p>'
			],
		];
	}
}