<?php

/**
* @package   My\Project
* @copyright Copyright (c) 2019 The s9e authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace My\Project\TextFormatter;

use s9e\TextFormatter\Configurator;
use s9e\TextFormatter\Configurator\Bundle as AbstractBundleConfigurator;

class BundleConfigurator extends AbstractBundleConfigurator
{
	/**
	* {@inheritdoc}
	*/
	public function configure(Configurator $configurator): void
	{
		// Set up the basic rules
		$configurator->rootRules->enableAutoLineBreaks();

		// Configure plugins
		$configurator->Autoemail;
		$configurator->Autolink;
		$configurator->BBCodes->addFromRepository('B');
		$configurator->BBCodes->addFromRepository('I');
		$configurator->BBCodes->addFromRepository('S');
		$configurator->BBCodes->addFromRepository('U');
		$configurator->BBCodes->addFromRepository('URL');
		$configurator->Emoji;
		$configurator->Escaper;
		$configurator->HTMLElements->aliasElement('a', 'URL');
		$configurator->HTMLElements->aliasAttribute('a', 'href', 'url');
		$configurator->HTMLElements->aliasElement('b', 'B');
		$configurator->HTMLElements->aliasElement('i', 'I');
		$configurator->HTMLElements->aliasElement('s', 'U');
		$configurator->HTMLElements->aliasElement('u', 'S');
		$configurator->Litedown->decodeHtmlEntities = true;

		// Configure the PHP renderer to exist in the current namespace
		$configurator->rendering->engine            = 'PHP';
		$configurator->rendering->engine->className = __NAMESPACE__ . '\\Renderer';
		$configurator->rendering->engine->filepath  = __DIR__ . '/Renderer.php';

		// Copy this file's header to generated PHP files
		preg_match('(/\\*+.*?\\*/)s', file_get_contents(__FILE__), $m);
		$configurator->phpHeader = $m[0];

		// Enable the JavaScript parser and configure the JavaScript minifier
		$configurator->enableJavaScript();
		$filepath = __DIR__ . '/../../node_modules/google-closure-compiler-linux/compiler';
		if (file_exists($filepath))
		{
			$configurator->javascript->setMinifier('ClosureCompilerApplication', $filepath);
		}
	}

	/**
	* Generate and save this bundle to current dir
	*
	* @return bool Whether the bundle file was saved successfully
	*/
	public static function saveBundle(): bool
	{
		$configurator = (new static)->getConfigurator();

		return $configurator->saveBundle(
			__NAMESPACE__ . '\\Bundle',
			__DIR__ . '/Bundle.php',
			['autoInclude' => false]
		);
	}
}