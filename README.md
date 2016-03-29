# HTML Component
## A small library to generate html components quickly with PHP.

### Supported components
- AlertView
- ListView
- StepView

#### AlertView
Show alert message. Based on Bootstrap
```
$alert = new AlertView('info'); //level: success, info, warning, danger
echo $alert->view(['message'=>'alert']);
```

#### ListView
Show key value list in columns.
```
$list = new ListView(2);
echo $list->view(['data'=>['field1'=>'value1', 'field2'=>'value2', 'field3'=>'value3']]);
```

#### StepView
Show steps.
```
$step = new StepView([['title'=>'step 1', 'descr'=>'one'], ['title'=>'step 2', 'descr'=>'two']]);
echo $step->view();
```

### Custom styles
All components can change styles and css classes by `setStyles($styles)` and `setCssClass($css)`.
