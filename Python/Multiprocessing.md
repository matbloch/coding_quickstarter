# Multiprocessing





## Subprocess



```python
from subprocess import Popen, PIPE

process = Popen(['swfdump', '/tmp/filename.swf', '-d'], stdout=PIPE, stderr=PIPE)
stdout, stderr = process.communicate()

print("retcode =", process.returncode)
```

