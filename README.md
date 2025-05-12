# Feed Processor

Welcome to the **Feed Processory**! A simple feed processor. Pass it a file location and it'll return the data.

## Usage Examples
The package currently supports csv, txt, rss, json and xml files. 

All you need to do is pass one of those file locations to it and call either `toArray()` or `toJson()` to get the contents.

```
use HalfShellStudios\FeedProcessor;

// CSV file
$processor = FeedProcessorFactory::make("./some_location/sample.csv");
$json = $processor->toJson();
$array = $processor->toArray();

// TXT file
$processor = FeedProcessorFactory::make("./some_location/sample.txt");
$json = $processor->toJson();
$array = $processor->toArray();

// RSS file
$processor = FeedProcessorFactory::make("./some_location/sample.rss");
$json = $processor->toJson();
$array = $processor->toArray();

// JSON file
$processor = FeedProcessorFactory::make("./some_location/sample.json");
$json = $processor->toJson();
$array = $processor->toArray();

// XML file
$processor = FeedProcessorFactory::make("./some_location/sample.xml");
$json = $processor->toJson();
$array = $processor->toArray();

```

If the file doesn't exist, a `FileDoesNotExistException` is thrown.
If the file is malformed in some way, a `FileMalformedException` is thrown.

Thats it!
