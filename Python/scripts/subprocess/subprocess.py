import subprocess
import time
import os
import re
import platform
import signal
import logging
import argparse
import sys
from io import BlockingIOError
import platform
import locale
if not platform.system() == 'Windows':
    import fcntl
else:
    import gevent.os


def process_output(line):
    print line
    return True


def nonblocking_readlines(f):
    """Generator which yields lines from F (a file object, used only for
       its fileno()) without blocking.  If there is no data, you get an
       endless stream of empty strings until there is data again (caller
       is expected to sleep for a while).
       Newlines are normalized to the Unix standard.
    """
    fd = f.fileno()
    if not platform.system() == 'Windows':
        fl = fcntl.fcntl(fd, fcntl.F_GETFL)
        fcntl.fcntl(fd, fcntl.F_SETFL, fl | os.O_NONBLOCK)
    enc = locale.getpreferredencoding(False)

    buf = bytearray()
    while True:
        try:
            if not platform.system() == 'Windows':
                block = os.read(fd, 8192)
            else:
                block = gevent.os.tp_read(fd, 8192)
        except (BlockingIOError, OSError):
            yield ""
            continue

        if not block:
            if buf:
                yield buf.decode(enc)
            break

        buf.extend(block)

        while True:
            r = buf.find(b'\r')
            n = buf.find(b'\n')
            if r == -1 and n == -1:
                break

            if r == -1 or r > n:
                yield buf[:(n + 1)].decode(enc)
                buf = buf[(n + 1):]
            elif n == -1 or n > r:
                yield buf[:r].decode(enc) + '\n'
                if n == r + 1:
                    buf = buf[(r + 2):]
                else:
                    buf = buf[(r + 1):]


def task_arguments(resources, env):

    # use resources to build task specific parameters

    task_specific_param = []

    args = [
        sys.executable,     # python executable
        os.path.join(       # app root
            os.path.dirname(os.path.abspath(__file__)),
            'test_exec.py'),  # executable path
        task_specific_param,
    ]

    return args


def run_subprocess(resources=None):
    unrecognized_output = []
    env = os.environ.copy()
    args = task_arguments(resources, env)
    # Convert them all to strings
    args = [str(x) for x in args]

    print os.path.abspath(__file__)
    print os.path.dirname(os.path.abspath(__file__))


    # start subprocess
    p = subprocess.Popen(args,
                              stdout=subprocess.PIPE,
                              stderr=subprocess.STDOUT,
                              cwd=os.path.dirname(os.path.abspath(__file__)),  # working directory (directory of task)
                              # close_fds=False if platform.system() == 'Windows' else True,
                              env=env,  # set environment variables
                              )

    # poll return
    try:
        sigterm_time = None  # When was the SIGTERM signal sent
        sigterm_timeout = 2  # When should the SIGKILL signal be sent

        while p.poll() is None:
            for line in nonblocking_readlines(p.stdout):
                # if self.aborted.is_set():
                #     if sigterm_time is None:
                #         # Attempt graceful shutdown
                #         p.send_signal(signal.SIGTERM)
                #         sigterm_time = time.time()
                #     break

                if line is not None:
                    # Remove whitespace
                    line = line.strip()

                if line:
                    # process output
                    if not process_output(line):
                        print "Unrecognized output"
                        # self.logger.warning('%s unrecognized output: %s' % (self.name(), line.strip()))
                        unrecognized_output.append(line)
                else:
                    time.sleep(0.05)
            if sigterm_time is not None and (time.time() - sigterm_time > sigterm_timeout):
                p.send_signal(signal.SIGKILL)
                print "SIGKILL"
                # self.logger.warning('Sent SIGKILL to task "%s"' % self.name())
                time.sleep(0.1)
            time.sleep(0.01)

    except:
        p.terminate()
        raise


# ================================= #
#              Main

if __name__ == '__main__':

    # start flask server

    # run subprocess
    run_subprocess()

