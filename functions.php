<?php
define('TAG_FEATURE', '@feature');
define('TAG_FEATURES_CATEGORIES', '@featuresCategories');
define('TAG_FEATURE_CATEGORIES', '@featureCategories');
define('TAG_IGNORE', '@ignore');

function myScanDir($dir, $ignore)
{
    $features = [];

    if (!is_dir($dir)) {
        throw new Exception('Chemin non valide.');
    }

    $list = scandir($dir);

    foreach ($list as $value) {
        if ($value[0] === '.') {
            continue;
        }

        $found = null;
        $file = $dir . DIRECTORY_SEPARATOR . $value;

        if (is_dir($file)) {
            $found = myScanDir($file, $ignore);
        }

        if (is_file($file)) {
            if (!preg_match('/\.php|\.js$/', $file)) {
                continue;
            }
            $found = myScanFile($file, $ignore);
        }

        if ($found) {
            //var_dump($found);
            $features = array_merge_recursive($features, $found);
        }
    }

    return $features;
}

/**
 *
 * @param type $filename
 * @return type
 */
function myScanFile($filename, $ignore)
{
    //echo $filename . "\n";
    $content = file_get_contents($filename);

    $features = [];
    $pFeatures = &$features;

    // Recherche de la catégorie principale
    if (preg_match('/' . TAG_FEATURES_CATEGORIES . ' (.*)/i', $content, $categories)) {
        foreach (explode('/', $categories[1]) as $value) {
            $pFeatures = &$pFeatures[trim($value)];
        }
    }

    // Zones phpDoc
    if (preg_match_all('/\/\*\*(.*?)\*\//s', $content, $comments)) {
        //var_dump($comments);
        foreach ($comments[1] as $comment) {
            //var_dump($comment);
            if (preg_match_all('/' . TAG_FEATURE . ' (.*)/i', $comment, $featuresComment)) {
                $pSubFeatures = &$pFeatures;

                // Recherche catégories
                if (preg_match('/' . TAG_FEATURE_CATEGORIES . ' (.*)/i', $comment, $categories)) {
                    foreach (explode('/', $categories[1]) as $value) {
                        $pSubFeatures = &$pSubFeatures[trim($value)];
                    }
                }

                foreach ($featuresComment[1] as $feature) {
                    if (strpos($comment, TAG_IGNORE) === false) {
                        $pSubFeatures[] = $feature;
                    } else {
                        if ($ignore) {
                            $pSubFeatures[] = TAG_IGNORE . ' ' . $feature;
                        }
                    }
                }
            }
        }
    }

    if (isset($pSubFeatures) && count($pSubFeatures)) {
        return $features;
    }

    return null;
}

function affFeatures(array $features)
{
    echo '<ul>';
    foreach ($features as $cat => $feature) {
        if (is_int($cat)) {
            echo '<li>' . $feature . '</li>';
        } else {
            echo '<li>' . $cat;
            affFeatures($feature);
            echo '</li>';
        }
    }
    echo '</ul>';
}