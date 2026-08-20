<?php
header("Content-Type: application/xml; charset=UTF-8");

require_once(__DIR__ . "/../config/database.php");
require_once(__DIR__ . "/../repositories/ProductRepository.php");

$db = new Database();
$productRepository = new ProductRepository($db->pdo);
$products = $productRepository->getAllProducts();

$scheme = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
$host = $_SERVER["HTTP_HOST"] ?? "localhost";
$baseUrl = $scheme . "://" . $host;

$xml = new DOMDocument("1.0", "UTF-8");
$xml->formatOutput = true;

$rss = $xml->createElement("rss");
$rss->setAttribute("version", "2.0");
$rss->setAttribute("xmlns:g", "http://base.google.com/ns/1.0");

$channel = $xml->createElement("channel");

$title = $xml->createElement("title", "Books Online Shop");
$link = $xml->createElement("link", $baseUrl);
$description = $xml->createElement("description", "Products from Books Online Shop");

$channel->appendChild($title);
$channel->appendChild($link);
$channel->appendChild($description);

foreach ($products as $product) {
    $item = $xml->createElement("item");

    $id = $xml->createElement("g:id");
    $id->appendChild($xml->createTextNode((string) ($product->id ?? "")));

    $productTitle = $xml->createElement("g:title");
    $productTitle->appendChild($xml->createTextNode(trim((string) ($product->title ?? ""))));

    $descriptionText = trim((string) ($product->description ?? ""));
    if ($descriptionText === "") {
        $descriptionText = trim((string) ($product->title ?? ""));
    }
    $productDescription = $xml->createElement("g:description");
    $productDescription->appendChild($xml->createTextNode($descriptionText));

    $productLink = $xml->createElement("g:link");
    $productLink->appendChild($xml->createTextNode($baseUrl . "/product?id=" . urlencode((string) ($product->id ?? ""))));

    $imageUrl = trim((string) ($product->img ?? ""));
    $imageLink = $xml->createElement("g:image_link");
    if ($imageUrl !== "") {
        $imageLink->appendChild($xml->createTextNode($imageUrl));
    } else {
        $imageLink->appendChild($xml->createTextNode($baseUrl . "/assets/no-image.png"));
    }

    $stock = (int) ($product->stock_quantity ?? 0);
    $availability = $xml->createElement("g:availability");
    $availability->appendChild($xml->createTextNode($stock > 0 ? "in_stock" : "out_of_stock"));

    $price = number_format((float) ($product->price ?? 0), 2, ".", "");
    $priceTag = $xml->createElement("g:price");
    $priceTag->appendChild($xml->createTextNode($price . " SEK"));

    $condition = $xml->createElement("g:condition");
    $condition->appendChild($xml->createTextNode("new"));

    $brand = $xml->createElement("g:brand");
    $brand->appendChild($xml->createTextNode("Quills"));

    $categoryName = trim((string) ($product->category_name ?? ""));
    $categoryTag = null;
    if ($categoryName !== "") {
        $categoryTag = $xml->createElement("g:google_product_category");
        $categoryTag->appendChild($xml->createTextNode($categoryName));
    }

    $item->appendChild($id);
    $item->appendChild($productTitle);
    $item->appendChild($productDescription);
    $item->appendChild($productLink);
    $item->appendChild($imageLink);
    $item->appendChild($availability);
    $item->appendChild($priceTag);
    $item->appendChild($condition);
    $item->appendChild($brand);

    if ($categoryTag !== null) {
        $item->appendChild($categoryTag);
    }

    $channel->appendChild($item);
}

$rss->appendChild($channel);
$xml->appendChild($rss);

echo $xml->saveXML();
exit;
