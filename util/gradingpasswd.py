#!/usr/bin/env python
import getpass
import hashlib
import sys

p1 = getpass.getpass('Enter password: ')
p2 = getpass.getpass('Enter password again: ')

if p1 != p2:
	print 'Error: passwords do not match'
	sys.exit(1)
else:
	m = hashlib.sha1()
	m.update(p1)
	print 'Hash: ', m.hexdigest()

