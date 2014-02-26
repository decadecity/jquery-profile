import numpy as np
from simplejson import load as load_json

from pprint import pprint

data_file = './public/data/results.json'

with open(data_file) as f:
    data = load_json(f)

tests = {}

for d in data:
    device = tests.get(d['device'], {})
    browser = device.get(d['browser']['browser']['name'], {})
    version = browser.get(d['jquery'], {})
    data_points = version.get('data', [])
    data_points.append(d['parse_time'])

    version['data'] = data_points
    browser[d['jquery']] = version
    device[d['browser']['browser']['name']] = browser
    tests[d['device']] = device

#pprint(tests)

results = {}

for device in tests.itervalues():
    for browser in device.itervalues():
        for version, results in browser.items():
            #pprint(results)
            data_points = results['data']
            a = np.array(data_points)
            results['mean'] = np.mean(a, dtype=np.float64)
            results['sigma'] = np.std(a, dtype=np.float64)
            results['number'] = len(data_points)
            del results['data']

pprint(tests)
