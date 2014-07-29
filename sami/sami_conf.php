<?php

$dir = dirname(__DIR__).'/src';

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('tests')
    ->in($dir)
;
/*
$versions = GitVersionCollection::create($dir)
    //->addFromTags('v1.0.*')
    //->add('1.0', '1.0 branch')
    ->add('master', 'master branch')
;
*/
return new Sami($iterator, array(
    'theme'                => 'symfony',
    //'versions'             => $versions,
    'versions'             => '0.2',
    'title'                => 'Erdiko API',
    'build_dir'            => __DIR__.'/build/',
    'cache_dir'            => __DIR__.'/cache/',
    //  'simulate_namespaces'  => true, 
    'default_opened_level' => 1,
));