<?php

return array(
    [['GET', 'POST'], '/', '/'],
    ['GET', '/login', 'login'],
    ['GET', '/login/error/{reason}', 'login'],
    ['POST', '/login', 'login@do'],
    ['/index', 'index'],
    ['/index/{key}', 'index'],
    ['/bucket/{do}', 'index@bucket'],
    ['/bucket/{do}/{id}', 'index@bucket'],
    ['/files', 'files'],
    ['/files/refresh', 'files@refresh'],
    ['/files/refresh/{marker}', 'files@refresh'],
    ['/files/{marker}', 'files'],
    ['/files/show/{key}', 'files@show'],
    ['/files/action/{do}', 'files@action'],
    ['/files/action/{do}/{key}', 'files@action'],

);
