// Source: http://www.anyexample.com/programming/java/java_simple_class_to_compute_sha_1_hash.xml
package org.pretendamazing.csgrade.util.conf;
import java.io.UnsupportedEncodingException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class Sha1 {
	public static boolean test() throws NoSuchAlgorithmException, UnsupportedEncodingException {
		String pythonSha1 = "5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8";
		String javaSha1 = Sha1.calculate("password");
		
		return pythonSha1.equals(javaSha1);
	}
	
	private static String convertToHex(byte[] data) {
		StringBuffer buf = new StringBuffer();
		
		for (int i = 0; i < data.length; i++) {
			int halfbyte = (data[i] >>> 4) & 0x0F;
			int two_halfs = 0;
			
			do {
				if ((0 <= halfbyte) && (halfbyte <= 9))
					buf.append((char) ('0' + halfbyte));
				else 
					buf.append((char) ('a' + (halfbyte - 10)));
				
				halfbyte = data[i] & 0x0F;
			} while (two_halfs++ < 1);
		}
		
		return buf.toString().toLowerCase();
	}
	
	public static String calculate(String text) throws NoSuchAlgorithmException, UnsupportedEncodingException {
		MessageDigest md = MessageDigest.getInstance("SHA-1");
		byte[] sha1hash = new byte[40];
		
		md.update(text.getBytes("utf-8"), 0, text.length());
		sha1hash = md.digest();
		
		return convertToHex(sha1hash);
	}
}
