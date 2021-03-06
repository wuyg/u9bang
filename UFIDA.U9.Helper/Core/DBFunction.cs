using System;
using System.Collections.Generic;
using System.Text;
using System.Data.SqlClient;
using System.Security.Cryptography;
using System.IO;
using System.Windows.Forms;
using System.Drawing;

namespace UFIDA.U9.Helper
{
    public class PubFunction
    {

        //Ĭ����Կ����   
        private static byte[] Keys = { 0x12, 0x34, 0x56, 0x78, 0x90, 0xAB, 0xCD, 0xEF };
        /// DES�����ַ���           
        /// �����ܵ��ַ���   
        /// ������Կ,Ҫ��Ϊ8λ   
        /// ���ܳɹ����ؼ��ܺ���ַ�����ʧ�ܷ���Դ��    
        public static string EncryptDES(string encryptString, string encryptKey)
        {
            try
            {
                byte[] rgbKey = Encoding.UTF8.GetBytes(encryptKey.Substring(0, 8));
                byte[] rgbIV = Keys;
                byte[] inputByteArray = Encoding.UTF8.GetBytes(encryptString);
                DESCryptoServiceProvider dCSP = new DESCryptoServiceProvider();
                MemoryStream mStream = new MemoryStream();
                CryptoStream cStream = new CryptoStream(mStream, dCSP.CreateEncryptor(rgbKey, rgbIV), CryptoStreamMode.Write);
                cStream.Write(inputByteArray, 0, inputByteArray.Length);
                cStream.FlushFinalBlock();
                return Convert.ToBase64String(mStream.ToArray());
            }
            catch
            {
                return encryptString;
            }
        }
        ///    
        /// DES�����ַ���           
        /// �����ܵ��ַ���   
        /// ������Կ,Ҫ��Ϊ8λ,�ͼ�����Կ��ͬ   
        /// ���ܳɹ����ؽ��ܺ���ַ�����ʧ�ܷ�Դ��   
        public static string DecryptDES(string decryptString, string decryptKey)
        {
            try
            {
                byte[] rgbKey = Encoding.UTF8.GetBytes(decryptKey);
                byte[] rgbIV = Keys;
                byte[] inputByteArray = Convert.FromBase64String(decryptString);
                DESCryptoServiceProvider DCSP = new DESCryptoServiceProvider();
                MemoryStream mStream = new MemoryStream();
                CryptoStream cStream = new CryptoStream(mStream, DCSP.CreateDecryptor(rgbKey, rgbIV), CryptoStreamMode.Write);
                cStream.Write(inputByteArray, 0, inputByteArray.Length);
                cStream.FlushFinalBlock();
                return Encoding.UTF8.GetString(mStream.ToArray());
            }
            catch
            {
                return decryptString;
            }
        }

        public static string GetStringValue(System.Xml.XmlAttribute attr)
        {
            if (attr != null && !string.IsNullOrEmpty(attr.Value))
                return attr.Value;
            return string.Empty;
        }
        public static bool GetBooleanValue(System.Xml.XmlAttribute attr)
        {
            if (attr != null && !string.IsNullOrEmpty(attr.Value))
                return Convert.ToBoolean(attr.Value);
            return false;
        }
    }
}