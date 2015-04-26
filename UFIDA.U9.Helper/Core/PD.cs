using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;
using log4net;

namespace UFIDA.U9.Helper
{
    public class PD
    {
        private static readonly ILog log = LogManager.GetLogger(typeof(PD));
        static PD()
        {
            try
            {
                m_MYSQL_ConnectionString = System.Configuration.ConfigurationManager.AppSettings["MYSQL"];
                m_MSSQL_ConnectionString = System.Configuration.ConfigurationManager.AppSettings["MSSQL"];

                PD.Title = System.Configuration.ConfigurationManager.AppSettings["Title"];
                
            }
            catch (Exception ex)
            {
                log.Error(ex);
                System.Windows.Forms.MessageBox.Show(ex.Message);
            }
        }
        private static string m_MYSQL_ConnectionString;
        public static string MYSQL_ConnectionString { get { return m_MYSQL_ConnectionString; } }

        private static string m_MSSQL_ConnectionString;
        public static string MSSQL_ConnectionString { get { return m_MSSQL_ConnectionString; } }

        public static string Title { get; set; }
    }
}