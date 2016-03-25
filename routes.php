<?php

return array(
    [['GET', 'POST'], '/', '/'],
    ['GET', '/login', 'login'],
    ['POST', '/login', 'login@do'],
    ['/index', 'index'],
    ['/bucket/{do}', 'index@bucket'],
    ['/bucket/{do}/{id}', 'index@bucket'],
    ['/files', 'files'],
    ['/files/{marker}', 'files'],
    ['/files/show/{key}', 'files@show'],
    ['/files/action/{do}', 'files@action'],
    ['/files/action/{do}/{key}', 'files@action'],

);