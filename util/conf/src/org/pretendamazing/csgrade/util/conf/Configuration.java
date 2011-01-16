package org.pretendamazing.csgrade.util.conf;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.util.ArrayList;
import javax.xml.bind.JAXBContext;
import javax.xml.bind.JAXBElement;
import javax.xml.bind.JAXBException;
import javax.xml.bind.Marshaller;
import javax.xml.bind.Unmarshaller;
import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement
public class Configuration {
	public String compilerBinary;
	public String makeBinary;
	public String homeDirectory;
	public String submittedFilesRoot;
	public String instructor;
	public String gradingPassword;
	public String mossBinary;
	public String mossLanguage;
	public ArrayList<Lab> lab;
	
	public Configuration()
	{
		// Set default settings where applicable
		this.compilerBinary = "/usr/bin/gfortran";
		this.makeBinary = "/usr/bin/make";
		this.gradingPassword = "5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8"; // "password"
		this.mossBinary = "/usr/local/bin/moss";
		this.mossLanguage = "fortran";
		
		// Set blank values for things that the user *must* specify
		this.homeDirectory = "";
		this.submittedFilesRoot = "";
		this.instructor = "";
		
		// Initialize the list of labs
		this.lab = new ArrayList<Lab>();
	}
	
	public void serialize(String filename) throws Exception {
		// Set up the marshaller
		JAXBContext context = JAXBContext.newInstance(Configuration.class);
		Marshaller m = context.createMarshaller();
		m.setProperty(Marshaller.JAXB_FORMATTED_OUTPUT, true);
		
		// Create our XML file
		m.marshal(this, new FileOutputStream(filename));
	}
	
	public static Configuration deserialize(String filename) throws Exception {
		JAXBContext context = JAXBContext.newInstance(new Class[] { org.pretendamazing.csgrade.util.conf.Configuration.class });
		Unmarshaller u = context.createUnmarshaller();
		
		return (Configuration) u.unmarshal(new FileInputStream(filename));
	}
}
