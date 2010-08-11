#!/usr/bin/python
from __future__ import with_statement
import getpass
import hashlib
import os
import sys
import subprocess
import tempfile


######################################################
##  ABOUT: csgrade grade script v0.0.2.1            ##
##         Copyright (C) 2010 Ross Nelson           ##
##                                                  ##
##  USE:   Two sections require use work; both are  ##
##         denoted with big blocks like this. You   ##
##         need to fill in variables inside the     ##
##         globals array as well as specify the     ##
##         assignments. Future versions will use    ##
##         a configuration file for this, but for   ##
##         now it requires changing the script      ##
######################################################



# Script configuration
globals = {
	'name':       'csgrade test/grade script',
	'version':    '0.0.2.1',
	'author':     'Ross Nelson <http://github.com/rnelson>',
	'copyright':  'Copyright (C) 2010 Ross Nelson',
	'license':    'BSD License (http://opensource.org/licenses/bsd-license.php)',
	
	#####################################################
	##  The following variables need to be configured  ##
	##  before you can use the script.                 ##
	#####################################################
	
	# Set this to your compiler, e.g., /usr/bin/cc /usr/bin/gfortran
	'compiler':   '',
	
	# Set this to your chosen make program, e.g, /usr/bin/make
	'make':       '',
	
	# Set this to your home directory; it expects a 'bin' directory to
	# exists underneath that holds solution files, e.g.,
	#                         /home/grad/Classes_102/cse150efl
	'homedir':    '',
	
	# Set this to the root of submitted files. This is the biggest part
	# that makes this script not useful outside of UNL's CSE department
	# right now as it's tied to how CSE submits files. csgrade is designed
	# to eventually function as a file submission, assignment testing/grading,
	# and ABET sampling system, but for now it will require some hacking
	# to make it more generic. e.g.,
	#                         /home/grad/Classes_102/cse150efl/webhandin
	'root':       '',
	
	# Set this to your name
	'instructor': '',
	
	# Set this to your password for grading; run gradingpasswd.py to generate
	# a password ("password" = '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8')
	'gradepass':  '',
	
	# Set this to the location of a moss.pl script to use MOSS for cheating
	# detection, e.g.,
	#                         /home/grad/Classes_102/cse150efl/moss.pl
	'moss':       ''
}

def getLab():
	return {
		'complete':  False,
		'num':       '',
		'name':      '',
		'shortname': '',
		'numparts':  '',
		'dir':       '',
		'parts':     None
	}

def getLabPart():
	return {
		'name':      '',
		'source':    '',
		'sources':   None,
		'basefiles': [],
		'binary':    '',
		'type':      '',
		'matchtype': '',
		'solbin':    '',
		'soltxt':    '',
		'solution':  '',
		'Makefile':  '',
		'mossglob':  ''
	}

def getGradeRet():
	return {
		'output':     '',
		'result':     '',
		'compOutput': '',
		'runOutput':  '',
		'diffOutput': '',
		'solOutput':  ''
	}

def getCompileRet():
	return {
		'command': '',
		'result':  '',
		'retval':  ''
	}

def getRunRet():
	return {
		'command': '',
		'result':  '',
		'retval':  ''
	}

def getDiffRet():
	return {
		'diffLines': '',
		'result':    '',
		'same':      ''
	}

def getLabDir(lab):
	return os.path.join(os.path.join(globals['root'], lab), 'unix')

def getBinaryPath(binaryName):
	return os.path.join(os.path.join(globals['homedir'], 'bin'), binaryName)


#################################################################
##  Create a list named 'assignments' here that is made up of  ##
##  'lab' and 'labPart' lists that describe the individual     ##
##  assignments. I have included a commented example showing   ##
##  basic use.                                                 ##
#################################################################



# # Compare the output, expecting only an integer
# # to be printed to the screen
# part = getLabPart()
# part['name'] = 'ex1'
# aprt['source'] = 'week7-ex1.f95'
# part['binary'] = 'a.out'
# aprt['type'] = 'intmatch'
# part['matchtype'] = 'static'
# part['solution'] = 681
# part['basefiles'] = []
# part['mossglob'] = getLabDir('7') + '/*/*.f9?'
# lab7 = getLab()
# lab7['complete'] = True
# lab7['num'] = 7
# lab7['name'] = 'Week 7'
# lab7['shortname'] = 'wk7'
# lab7['numparts'] = 1
# lab7['dir'] = getLabDir('7')
# lab7['parts'] = []
# lab7['parts'].append(part)
# 
# 
# # Compare the output to that of a reference program;
# # there is also a shared main()-type file compiled
# # in with student source
# part = getLabPart()
# part['name'] = 'ex1'
# part['source'] = 'week8.f95'
# part['sources'] = [ '~cse150efl/files/week8-main.f95' ]
# part['binary'] = 'a.out'
# part['type'] = 'binmatch'
# part['solbin'] = getBinaryPath('week8-reference')
# part['basefiles'] = []
# part['mossglob'] = getLabDir('8') + '/*/*.f9?'
# lab8 = getLab()
# lab8['complete'] = True
# lab8['num'] = 8
# lab8['name'] = 'Week 8'
# lab8['shortname'] = 'wk8'
# lab8['numparts'] = 1
# lab8['dir'] = getLabDir('8')
# lab8['parts'] = []
# lab8['parts'].append(part)
# 
# 
# # A lab can have multiple parts, and they can be graded different
# # ways -- part 1 is compiled with a Makefile and part 2 is a simple
# # binary output comparison. Note the 'numparts' variable. I'm not
# # entirely sure this is being used, and it shouldn't. I plan to do
# # a complete overhaul of the assignment specification stuff so I'm
# # not going to worry about it for now.
# lab10 = getLab()
# lab10['complete'] = True
# lab10['num'] = 10
# lab10['name'] = 'Week 10'
# lab10['shortname'] = 'wk10'
# lab10['numparts'] = 2
# lab10['dir'] = getLabDir('10')
# lab10['parts'] = []
# part = getLabPart()
# part['name'] = 'ex1'
# part['source'] = 'week10.f95'
# part['Makefile'] = '/home/grad/Classes_102/cse150efl/files/Makefile.week10'
# part['binary'] = 'week10'
# part['type'] = 'make-run'
# part['basefiles'] = ['/home/grad/Classes_102/cse150efl/public_html/labs/10/week10-help.f90']
# part['mossglob'] = getLabDir('10') + '/*/*.f9?'
# lab10['parts'].append(part)
# part = getLabPart()
# part['name'] = 'ex2'
# part['source'] = 'week11.f95'
# part['sources'] = [ '~cse150efl/files/week11-main.f95' ]
# part['binary'] = 'a.out'
# part['type'] = 'binmatch'
# part['solbin'] = getBinaryPath('week11-reference')
# lab10['parts'].append(part)
# 
# # Now create the actual assignments list and put the
# # assignments into it
# assignments = []
# assignments.append(lab7)
# assignments.append(lab8)
# assignments.append(lab10)





# Deal with command line arguments
grading = False
verbose = False
moss = False
showHelp = False
assignment = None # len(assignments) # default assignment

# TODO: this should be replaced with OptParse stuff
if len(sys.argv) > 1:
	# Copy the arguments and get rid of 'test.py'
	args = sys.argv
	del args[0]
	
	for a in sys.argv:
		# Remove spaces on the ends
		arg = a.strip()
		
		# Check for flags
		if arg.startswith('-'):
			if arg == '-g':
				grading = True
			if arg == '-v':
				verbose = True
			if arg == '-m':
				moss = True
			if arg == '-h' or arg == '--help':
				showHelp = True
		else:
			# If it's not a flag, it's an argument number
			try:
				num = int(arg)
				assignment = num
			except:
				print 'Error: assignment ' + arg + ' does not exist'
				sys.exit(1)


# Variables
grades = []


# Utility functions
def mktmpnam():
	f = tempfile.NamedTemporaryFile()
	tmp = f.name
	f.close()
	return tmp

def exists(filename):
	return os.path.exists(filename)

def unlink(filename):
	if filename == None:
		return
	
	if os.path.exists(filename):
		os.unlink(filename)

def findLab(number):
	for l in assignments:
		if l['num'] == number:
			return l
	
	return None

def buildFileList(studentSource, part):
	fileList = studentSource
	
	if part['sources'] != None:
		for f in part['sources']:
			fileList = fileList + ' ' + f
	
	return fileList

def make(student, lab, part, src, showOutput=False, outputFilename='', make=globals['make'], cd=False, studentDir=''):
	ret = getCompileRet()
	
	if cd:
		os.chdir(studentDir)
	
	# If the file doesn't exist, save time and flag it as such here
	if not exists(src):
		ret['retval'] = -1
		ret['result'] = '(-) "' + src + '" does not exist'
		ret['output'] = ''
		
		if verbose:
			print ret['result']
		
		return ret
	
	# Base compilation command
	command = make + ' -f ' + part['Makefile'] + ' clean >/dev/null 2>/dev/null && ' + make + ' -f ' + part['Makefile']
	
	# What do we do with the output?
	out = ''
	outStdout = ''
	outStderr = ''
	
	if not showOutput or grading:
		out = '>/dev/null 2>/dev/null'
	else:
		outStdout = mktmpnam()
		outStderr = mktmpnam()
		
		out = '>' + outStdout + ' 2>' + outStderr
	command = command + ' ' + out
	
	# Save the command used
	ret['command'] = command
	
	# Compile the code
	retval = subprocess.call(command, shell=True)
	ret['retval'] = retval
	
	# Log the results
	if retval == 0:
		ret['result'] = '( ) Made'
	else:
		ret['result'] = '(-) Make failed'
	
	if verbose:
		print student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']
	
	# If the user requested output saved to a file, we need to get it from two files into one
	if showOutput and outputFilename != '':
		stdoutFile = open(outStdout, 'r')
		stderrFile = open(outStderr, 'r')
		outfile = open(outputFilename, 'w')
		
		for line in stdoutFile:
			outfile.write(line)
		for line in stderrFile:
			outfile.write(line)
		
		stdoutFile.close()
		stderrFile.close()
		outfile.close()
	
	return ret

def compile(student, lab, part, bin, src, showOutput=False, outputFilename='', compiler=globals['compiler']):
	ret = getCompileRet()
	
	# If the file doesn't exist, save time and flag it as such here
	if not exists(src):
		ret['retval'] = -1
		ret['result'] = '(-) "' + src + '" does not exist'
		ret['output'] = ''
		
		if verbose:
			print ret['result']
		
		return ret
	
	# Base compilation command
	command = compiler + ' -o ' + bin + ' ' + buildFileList(src, part)
	
	# What do we do with the output?
	out = ''
	outStdout = ''
	outStderr = ''
	
	if not showOutput:
		out = '>/dev/null'
	else:
		outStdout = mktmpnam()
		outStderr = mktmpnam()
		
		out = '>' + outStdout + ' 2>' + outStderr
	command = command + ' ' + out
	
	# Hide output if grading
	if grading:
		command = command + ' >/dev/null 2>/dev/null'
	
	# Save the command used
	ret['command'] = command
	
	# Compile the code
	retval = subprocess.call(command, shell=True)
	ret['retval'] = retval
	
	# Log the results
	if retval == 0:
		ret['result'] = '( ) Compiled'
	else:
		ret['result'] = '(-) Compilation error'
	
	if verbose:
		print student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']
	
	# If the user requested output saved to a file, we need to get it from two files into one
	if showOutput and outputFilename != '':
		stdoutFile = open(outStdout, 'r')
		stderrFile = open(outStderr, 'r')
		outfile = open(outputFilename, 'w')
		
		for line in stdoutFile:
			outfile.write(line)
		for line in stderrFile:
			outfile.write(line)
		
		stdoutFile.close()
		stderrFile.close()
		outfile.close()
	
	return ret

def run(student, lab, part, bin, showOutput=False, outputFilename=''):
	ret = getRunRet()

	# Base command
	command = bin
	
	# Is verbose mode on? If so, pass that on to the binary (assume -v for it as well)
	v = ''
	if verbose:
		v = '-v'
	command = command + ' ' + v

	# What do we do with the output?
	out = ''
	if not showOutput:
		out = '>/dev/null'
	else:
		outStdout = mktmpnam()
		outStderr = mktmpnam()

		out = '>' + outStdout + ' 2>' + outStderr
	command = command + ' ' + out

	# Save the command used
	ret['command'] = command

	# Run the program
	retval = subprocess.call(command, shell=True)
	ret['retval'] = retval

	# Log the results
	if retval == 0:
		ret['result'] = '( ) Ran successfully'
	else:
		ret['result'] = '(-) Program crashed'
	
	if verbose:
		print student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']

	# If the user requested output saved to a file, we need to get it from two files into one
	if showOutput and outputFilename != '':
		stdoutFile = open(outStdout, 'r')
		stderrFile = open(outStderr, 'r')
		outfile = open(outputFilename, 'w')
		
		for line in stdoutFile:
			outfile.write(line)
		for line in stderrFile:
			outfile.write(line)
		
		stdoutFile.close()
		stderrFile.close()
		outfile.close()

	return ret

def dualRead(file1, file2):
	o = open(file1, 'r')
	t = open(file2, 'r')
	
	return o, t

def dualClose(file1, file2):
	file1.close()
	file2.close()

def diff(student, lab, part, userFile, solFile):
	ret = getDiffRet()
	ret['diffLines'] = 0
	ret['result'] = ''
	ret['same'] = False
	
	runres = 'Wrong output'
	
	try:			
		# Count the lines in each file
		f, s = dualRead(userFile, solFile)
		fCount = 0
		sCount = 0
		for line in f:
			fCount = fCount + 1
		for line in s:
			sCount = sCount + 1
		dualClose(f, s)
		
		ret['diffLines'] = abs(fCount - sCount)
		
		# If the user has verbose mode turned on, show the contents
		# of the two files
		if verbose:
			f, s = dualRead(userFile, solFile)
			
			print student + '/' + lab['shortname'] + part['name'] + ':  ( ) ' + str(fCount) + ' lines in your output'
			for line in f:
				print '  ' + line.rstrip()
			
			print student + '/' + lab['shortname'] + part['name'] + ':  ( ) ' + str(sCount) + ' lines in solution'
			for line in s:
				print '  ' + line.rstrip()
		
		# Now, see if the contents are the same
		same = True
		if fCount != sCount:
			same = False
			
			if verbose:
				pt1 = student + '/' + lab['shortname'] + part['name'] + ':  (-) Line counts differ: '
				pt2 = str(fCount) + ' vs ' + str(sCount)
				print pt1 + pt2
		else:
			f, s = dualRead(userFile, solFile)
							
			for i in xrange(fCount):
				fLine = f.readline()
				sLine = s.readline()
				
				if fLine != sLine:
					same = False
					
					if verbose:
						print student + '/' + lab['shortname'] + part['name'] + ':  (-) Lines differ:'
						print ' >"' + fLine + '"'
						print ' >"' + sLine + '"'
					
					break
			
			dualClose(f, s)
		
		if same:
			runres = 'Correct'
		
		ret['same'] = same
	except Exception, e:
		ret['same'] = False
		runres = 'Exception thrown comparing files: ' + e.message #str(sys.exc_info()[0])
	
	if ret['same']:
		ret['result'] = '(+) Correct'
	else:
		ret['result'] = '(-) ' + runres
	
	return ret


# Grading functions
def gradeIntmatch(student, lab, part, solution):
	# Variables
	ret = getGradeRet()
	ldir = lab['dir']
	studentDir = os.path.join(ldir, student)
	binpath = part['binary']
	srcpath = part['source']
	compRet = getCompileRet()
	runRet = getRunRet()
	
	if grading:
		binpath = os.path.join(studentDir, part['binary'])
		srcpath = os.path.join(studentDir, part['source'])
	
	# Compile the code
	if grading:
		compRet = compile(student, lab, part, binpath, srcpath)
	else:
		ret['compOutput'] = mktmpnam()
		compRet = compile(student, lab, part, binpath, srcpath, True, ret['compOutput'])
	
	# If it didn't error out, run it
	if compRet['retval'] != 0:
		ret['result'] = compRet['result']
		ret['output'] = ret['compOutput']
		
		if ret['result'] == '(-) "' + srcpath + '" does not exist':
			ret['output'] = ''
		return ret
	else:
		# We want to save the output to a file in all cases since we'll be
		# determining correctness by reading from it
		ret['runOutput'] = mktmpnam()
		runRet = run(student, lab, part, binpath, True, ret['runOutput'])
	
	# Did the program run correctly?
	if runRet['retval'] != 0:
		ret['result'] = runRet['result']
		ret['output'] = ret['runOutput']
		return ret
	else:
		ret['output'] = None
		runres = '(-) Wrong output'
		
		try:
			f = open(ret['runOutput'], 'r')
		
			try:
				number = int(f.read())
		
				if number == solution:
					runres = '(+) Correct'
			finally:
				f.close()
		except:
			pass
		
		ret['result'] = runres
	
	return ret

def gradeTxtmatch(student, lab, part, solutionFile):
	# Variables
	ret = getGradeRet()
	ldir = lab['dir']
	studentDir = os.path.join(ldir, student)
	binpath = part['binary']
	srcpath = part['source']
	compRet = getCompileRet()
	runRet = getRunRet()
	
	if grading:
		binpath = os.path.join(studentDir, part['binary'])
		srcpath = os.path.join(studentDir, part['source'])
	
	# Compile the code
	if grading:
		compRet = compile(student, lab, part, binpath, srcpath)
	else:
		ret['compOutput'] = mktmpnam()
		compRet = compile(student, lab, part, binpath, srcpath, True, ret['compOutput'])
	
	# If it didn't error out, run it
	if compRet['retval'] != 0:
		ret['result'] = compRet['result']
		ret['output'] = ret['compOutput']
		
		if ret['result'] == '(-) "' + srcpath + '" does not exist':
			ret['output'] = ''
		return ret
	else:
		# We want to save the output to a file in all cases since we'll be
		# determining correctness by reading from it
		ret['runOutput'] = mktmpnam()
		runRet = run(student, lab, part, binpath, True, ret['runOutput'])
	
	# Did the program run correctly?
	if runRet['retval'] != 0:
		ret['result'] = runRet['result']
		ret['output'] = ret['runOutput']
		return ret
	else:
		ret['output'] = None
		d = diff(student, lab, part, solutionFile, ret['runOutput'])
		ret['result'] = d['result']
	
	return ret

def gradeBinmatch(student, lab, part):
	ret = getGradeRet()
	
	# Get a filename to save the output to
	solOutput = mktmpnam()
	ret['solOutput'] = solOutput
	
	# Run the solution program
	command = part['solbin'] + ' > ' + solOutput
	binrunret = subprocess.call(command, shell=True)
	
	if verbose:
		print student + '/' + lab['shortname'] + part['name'] + ':  ' + '( ) Binrunret = ' + str(binrunret)
	
	# Grade
	ret = gradeTxtmatch(student, lab, part, solOutput)
	
	# Done
	unlink(solOutput)
	return ret

def gradeMakeRun(student, lab, part):
	# Variables
	ret = getGradeRet()
	ldir = lab['dir']
	
	compRet = getCompileRet()
	runRet = getRunRet()
	
	# Compile the code
	if grading:
		compRet = make(student, lab, part, part['source'], False, ret['compOutput'], globals['make'], True, os.path.join(ldir, student))
	else:
		ret['compOutput'] = mktmpnam()
		compRet = make(student, lab, part, part['source'], True, ret['compOutput'])
	
	# If it didn't error out, run it
	if compRet['retval'] != 0:
		ret['result'] = compRet['result']
		ret['output'] = ret['compOutput']
		
		#print '>>> Error running make'
		if ret['result'] == '(-) "' + part['source'] + '" does not exist':
			ret['output'] = ''
		return ret
	#else:
		## We want to save the output to a file in all cases since we'll be
		## determining correctness by reading from it
		#ret['runOutput'] = mktmpnam()
		#print student + '/' + lab['shortname'] + part['name'] + ':  ( ) Output:'
		#print '          -----------------'
		#runRet = run(student, lab, part, binpath, True, ret['runOutput'])
		#print '          -----------------'
	#
	## Did the program run correctly?
	#if runRet['retval'] != 0:
	#	ret['result'] = runRet['result']
	#	ret['output'] = ret['runOutput']
	#	return ret
	#else:
	#	ret['output'] = None
	#	runres = '( ) Program ran (cannot automatically determine correctness)'
	#	ret['result'] = runres
	
	ret['output'] = None
	ret['result'] = '( ) Program cannot be run automatically; run "' + part['binary'] + '" manually'
	
	return ret

def grade(student, lab):
	res = []
	
	for part in lab['parts']:
		ret = None
		pType = part['type']
		
		if pType == 'binmatch':
			# Compile + run the code
			ret = gradeBinmatch(student, lab, part)
		elif pType == 'txtmatch':
			# Compile + run the code
			ret = gradeTxtmatch(student, lab, part, solutionFile)
		elif pType == 'intmatch':
			solution = None
			
			if part['matchtype'] == 'bin':
				out = mktmpnam()
				command = part['solbin'] + ' > ' + out
				subprocess.call(command, shell=True)
				
				f = open(out, 'r')
				solution = int(f.read())
				f.close()
			elif part['matchtype'] == 'txt':
				f = open(part['soltxt'], 'r')
				solution = int(f.read())
				f.close()
			elif part['matchtype'] == 'static':
				solution = part['solution']
			
			# Compile + run the code
			ret = gradeIntmatch(student, lab, part, solution)
		elif pType == 'make-run':
			ret = gradeMakeRun(student, lab, part)
		else:
			print 'Error: don\'t know how to grade ' + lab['name'] + ' ' + part['name']
			sys.exit(3)
		
		# Get (and maybe print) the results
		resStr = student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']
		res.append(resStr)
		
		if not grading:
			print resStr
			
			if ret['output'] != None and ret['output'] != '':
				print ''
				print 'Output:'
			
				# There was an error somewhere; print the file contents
				f = open(ret['output'], 'r')
				for line in f:
					print '   ' + line.rstrip()
				f.close()
		
		# Clean up the files we used
		unlink(ret['compOutput'])
		unlink(ret['runOutput'])
		unlink(ret['diffOutput'])
		unlink(ret['solOutput'])
	
	return res

def about():
	print globals['name'] + ' ' + globals['version']
	print globals['author']
	print 'Licensed under ' + globals['license']
	print ''
	print 'Instructor:            ' + globals['instructor']
	print 'Compiler:              ' + globals['compiler']
	print 'Home directory:        ' + globals['homedir']
	print 'Code root directory:   ' + globals['root']
	print ''
	print ''

def help():
	print 'usage: ' + __file__ + ' [options] lab'
	print '   -h | --help:     Show this help'
	print '   -g:              Use grading mode (instructor only)'
	print '   -v:              Use verbose mode'
	print ''
	print '"lab" is the number for the lab you wish to test. You can'
	print 'obtain a list of valid numbers from your instructor (see'
	print 'instructor information above).'

if __name__ == '__main__':
	# If they requested help, regardless of other flags, show that and quit
	if showHelp:
		about()
		help()
		sys.exit(0)
	
	# Find the lab we want to check
	lab = findLab(assignment)
	if lab == None:
		print 'Error: that lab does not exist'
		#print 'Error: cannot find lab structure; notify ' + globals['instructor']
		sys.exit(2)
	
	if not lab['complete']:
		print 'Error: lab cannot be tested with test.py'
		sys.exit(3)
	
	# Do the actual testing/grading
	if not grading and not moss:
		student = os.environ.get('USER')
		grade(student, lab)
	else:
		# Verify the user is authorized to grade
		pw = getpass.getpass('Password: ')
		h = hashlib.sha1(pw).hexdigest()
		
		if h != globals['gradepass']:
			print 'Error: incorrect password'
			sys.exit(-42)
		
		if grading:
			grades = []
			labdir = lab['dir']
		
			for d in os.listdir(labdir):
				if os.path.isdir(os.path.join(labdir, d)):
					studentRes = grade(d, lab)
				
					#grades.append(studentRes)
					for res in studentRes:
						grades.append(res)
		
			grades.sort()
			for g in grades:
				print g
		elif moss:
			for p in lab['parts']:
				if p['mossglob'] != '':
					command = globals['moss'] + ' -c ' + lab['shortname'] + p['name'] + ' -l fortran -m 3 '
					for b in p['basefiles']:
						command = command + ' -b ' + b + ' '
					command = command + p['mossglob']
				
					subprocess.call(command, shell=True)
